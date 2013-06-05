<?php

namespace PMT\WebBundle\Controller;

use PMT\CoreBundle\Entity\Issue\Issue;
use PMT\WebBundle\Form\Type\IssueType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class IssueController extends Controller
{
	/**
	 * @Template()
	 * @Route("/issue/add", name="issue_form")
	 */
	public function formAction(Request $request)
	{
		$issue = new Issue();

		$form = $this->createForm(new IssueType($this->getDoctrine()->getManager()), $issue);

		$form
			->add(
				'rebuild',
				'checkbox',
				array(
					'label' => 'Create another',
					'required' => false,
					'property_path' => false,
				)
			)
			->add(
				'currentPath',
				'hidden',
				array(
					'data' => $this->getRequest()->getPathInfo(),
					'property_path' => false,
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
					$redirectUrl = $form->get('currentPath')->getData();
				} else {
					$redirectUrl = $this->generateUrl(
						'issue_detail',
						array(
							'project_code' => $issue->getProject()->getCode(),
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
	 * @Route("/{project_code}/{id}", requirements={"id" = "\d+"}, name="issue_detail")
	 */
	public function detailAction($id)
	{
		$issue = $this->getIssue($id);

		return array(
			'issue' => $issue,
		);
	}

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
