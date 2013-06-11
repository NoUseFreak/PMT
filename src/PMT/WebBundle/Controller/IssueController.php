<?php

namespace PMT\WebBundle\Controller;

use PMT\CoreBundle\Entity\Issue\Issue;
use PMT\CoreBundle\Model\WorkflowManager;
use PMT\WebBundle\Form\Type\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class IssueController extends Controller
{
    /**
     * @Template()
     * @Route("/add", defaults={"projectCode": "0"}, name="pmtweb_issue_form")
     * @Route("/{projectCode}/add", name="pmtweb_project_issue_form")
     */
    public function formAction($projectCode, Request $request)
    {
        $issue = new Issue();

        $form = $this->createForm(
            new IssueType($this->getDoctrine()->getManager(), array(
                'activeUser' => $this->get('security.context')->getToken()->getUser(),
            )),
            $issue
        );

        if ($projectCode) {
            $project = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Project\Project')
                ->findByCode($projectCode);
            if ($project) {
                $form->get('project')->setData($project);
            } else {
                return $this->redirect($this->generateUrl('pmtweb_issue_form'));
            }
        }

        $form
            ->add(
                'rebuild',
                'checkbox',
                array(
                    'label' => 'Create another',
                    'required' => false,
                    'mapped' => false,
                    'data' => $this->getRequest()->query->has('rebuild'),
                )
            )
            ->add(
                'currentPath',
                'hidden',
                array(
                    'data' => $this->getRequest()->getPathInfo(),
                    'mapped' => false,
                )
            );

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $em = $this->getDoctrine()->getManager();
                $em->persist($issue);
                $em->flush();

                if ($form->get('rebuild')->getData()) {
                    $redirectUrl = $form->get('currentPath')->getData() . '?rebuild';
                } else {
                    $redirectUrl = $this->generateUrl(
                        'pmtweb_issue_detail',
                        array(
                            'projectCode' => $issue->getProject()->getCode(),
                            'id' => $issue->getId(),
                        )
                    );
                }

                return $this->redirect($redirectUrl);
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template()
     * @Route("/{projectCode}/{id}", requirements={"id" = "\d+"}, name="pmtweb_issue_detail")
     */
    public function detailAction($id)
    {
        $issue = $this->getIssue($id);

        $manager = new WorkflowManager($this->getDoctrine()->getManager());

        return array(
            'issue' => $issue,
            'nextSteps' => $manager->getNextSteps($issue->getProject()->getWorkflow(), $issue->getStatus()),
            'backSteps' => $manager->getPreviousSteps($issue->getProject()->getWorkflow(), $issue->getStatus()),
        );
    }

    /**
     * @Route("/{projectCode}/{id}/step/{stepId}", requirements={"id" = "\d+"}, name="pmtweb_issue_new_step")
     */
    public function newStepAction($projectCode, $id, $stepId)
    {
        $issue = $this->getIssue($id);
        $step = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Workflow\WorkflowStep')->find($stepId);

        $workflowManager = new WorkflowManager($this->getDoctrine()->getManager());
        if ($workflowManager->setToStep($issue, $step)) {
            // set success message
        }
        else {
            // set failure message
        }

        return $this->redirect(
            $this->generateUrl(
                'pmtweb_issue_detail',
                array(
                    'projectCode' => $projectCode,
                    'id' => $id,
                )
            )
        );
    }

    /**
     * @param $id
     * @return Issue
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function getIssue($id)
    {
        $issue = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Issue\Issue')
            ->find($id);

        if (!$issue) {
            throw $this->createNotFoundException('Issue could not be found.');
        }

        return $issue;
    }
}
