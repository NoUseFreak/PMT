<?php

namespace PMT\WebBundle\Controller;

use PMT\CoreBundle\Model\ActivityManager;
use PMT\CoreBundle\Entity\Project\Project;
use PMT\CoreBundle\Model\ProjectManager;
use PMT\WebBundle\Form\Type\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    /**
     * @Template()
     * @Route("/project/create", name="pmtweb_project_form")
     */
    public function createFormAction(Request $request)
    {
        $project = new Project();

        $form = $this->createForm(
            new ProjectType($this->getDoctrine()->getManager(), array(
                'activeUser' => $this->get('security.context')->getToken()->getUser(),
            )),
            $project
        );

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $projectManager = new ProjectManager($this->getDoctrine()->getManager());
                if ($projectManager->saveProject($project)) {
                    $redirectUrl = $this->generateUrl(
                        'pmtweb_project_summary',
                        array(
                            'code' => $project->getCode(),
                        )
                    );

                    $this->get('session')->getFlashBag()->add('success', 'New project created!');

                    return $this->redirect($redirectUrl);
                }

            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * @Template()
     * @Route("/{projectCode}/edit", name="pmtweb_project_edit")
     */
    public function editFormAction($projectCode, Request $request)
    {
        $project = $this->getProject($projectCode);

        $form = $this->createForm(
            new ProjectType($this->getDoctrine()->getManager(), array(
                'activeUser' => $this->get('security.context')->getToken()->getUser(),
            )),
            $project
        );

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $projectManager = new ProjectManager($this->getDoctrine()->getManager());
                if ($projectManager->saveProject($project)) {
                    $redirectUrl = $this->generateUrl(
                        'pmtweb_project_summary',
                        array(
                            'code' => $project->getCode(),
                        )
                    );

                    $this->get('session')->getFlashBag()->add('success', 'Project updated!');

                    return $this->redirect($redirectUrl);
                }

            }
        }

        return array(
            'form' => $form->createView(),
            'project' => $project,
        );
    }

    /**
     * @Template()
     * @Route("/{code}/summary", name="pmtweb_project_summary")
     */
    public function summaryAction($code)
    {
        $project = $this->getProject($code);

        $logManager = new ActivityManager(
            $this->getDoctrine()->getManager(),
            $this->get('security.context')->getToken()->getUser()
        );

        return array(
            'project' => $project,
            'activity' => $logManager->getProjectLog($project),
        );
    }

    /**
     * @Template()
     * @Route("/{code}/issues", name="pmtweb_project_issues")
     */
    public function issuesAction($code)
    {
        $project = $this->getProject($code);

        return array(
            'project' => $project,
        );
    }

    /**
     * @Template()
     * @Route("/{projectCode}/milestones", name="pmtweb_project_milestones")
     */
    public function milestonesAction($projectCode)
    {
        $project = $this->getProject($projectCode);

        return array(
            'project' => $project,
        );
    }

    private function getProject($code)
    {
        $project = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Project\Project')
            ->findByCode($code);

        if (!$project) {
            throw $this->createNotFoundException('Project could not be found.');
        }

        return $project;
    }
}
