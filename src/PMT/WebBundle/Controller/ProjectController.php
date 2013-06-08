<?php

namespace PMT\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ProjectController extends Controller
{
    /**
     * @Template()
     * @Route("/{code}/summary", name="pmtweb_project_summary")
     */
    public function summaryAction($code)
    {
        $project = $this->getProject($code);

        return array(
            'project' => $project,
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
