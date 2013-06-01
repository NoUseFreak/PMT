<?php

namespace PMT\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProjectController extends Controller
{
	/**
	 * @Template()
	 * @Route("/project/summary", name="project_summary")
	 */
	public function summaryAction()
    {
        return array();
    }

	/**
	 * @Template()
	 * @Route("/project/issues", name="project_issues")
	 */
	public function issuesAction()
	{
		return array();
	}
}
