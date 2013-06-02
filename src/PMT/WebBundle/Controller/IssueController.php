<?php

namespace PMT\WebBundle\Controller;

use PMT\CoreBundle\Entity\Issue\Issue;
use PMT\WebBundle\Form\Type\IssueFormType;
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

	    $form = $this->createForm(new IssueFormType(), $issue);

	    if ($request->isMethod('POST')) {
		    $form->bind($request);

		    if ($form->isValid()) {
			    // perform some action, such as saving the task to the database
			    $em = $this->getDoctrine()->getManager();
			    $em->persist($issue);
			    $em->flush();
			    return $this->redirect($this->generateUrl('dashboard'));
		    }
	    }

	    $form
		    ->add(
			    'rebuild',
			    'checkbox',
			    array(
				    'label' => 'Create another',
				    'required' => false,
				    "property_path" => false,
			    )
		    );

	    return array(
		    'form' => $form->createView(),
	    );
    }

	/**
	 * @Template()
	 * @Route("/issue/detail", name="issue_detail")
	 */
	public function detailAction()
	{
		return array();
	}
}
