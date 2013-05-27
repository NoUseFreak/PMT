<?php

namespace PMT\WebBundle\Controller;

use PMT\WebBundle\Form\Type\IssueFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class IssueController extends Controller
{
	/**
	 * @Template()
	 * @Route("/issue/add", name="issue_form")
	 */
	public function formAction()
    {
	    $form = $this->createForm(new IssueFormType());

	    return array(
		    'form' => $form->createView(),
	    );
    }
}
