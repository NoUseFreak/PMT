<?php

namespace PMT\WebBundle\Controller;

use PMT\CoreBundle\Entity\Issue\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="dashboard")
     */
    public function dashboardAction()
    {
        $issues = $this->getDoctrine()->getRepository('PMT\\CoreBundle\\Entity\\Issue\\Issue')
            ->findAllForUserInStatus($this->get('security.context')->getToken()->getUser(), Status::IN_PROGRESS);

        return array(
            'issues' => $issues,
        );
    }
}
