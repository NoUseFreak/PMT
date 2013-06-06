<?php

namespace PMT\WebBundle\Controller;

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
        $issues = $this->getDoctrine()->getRepository('PMT\\CoreBundle\\Entity\\Issue\\Issue')->findCriticalForUser();

        return array(
            'issues' => $issues,
        );
    }
}
