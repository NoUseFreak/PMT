<?php

namespace PMT\WebBundle\Controller;

use PMT\CoreBundle\Entity\Issue\Status;
use PMT\CoreBundle\Model\ActivityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Template()
     * @Route("/", name="pmtweb_dashboard")
     */
    public function dashboardAction()
    {
        $issues = $this->getDoctrine()->getRepository('PMT\\CoreBundle\\Entity\\Issue\\Issue')
            ->findAllForUserInStatus($this->get('security.context')->getToken()->getUser(), Status::IN_PROGRESS);

        $logManager = new ActivityManager(
            $this->getDoctrine()->getManager(),
            $this->get('security.context')->getToken()->getUser()
        );

        return array(
            'issues' => $issues,
            'activity' => $logManager->getDashboardLog(),
        );
    }
}
