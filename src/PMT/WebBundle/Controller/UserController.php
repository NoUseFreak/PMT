<?php

namespace PMT\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller
{
    /**
     * @Template()
     * @Route("/users/{username}", name="pmtweb_user_profile")
     */
    public function profileAction($username)
    {
        $user = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\User')
            ->findOneByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException('The user could not be found');
        }

        $issues = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Issue\Issue')
            ->findAllForUser($user);

        return array(
            'user' => $user,
            'issues' => $issues,
        );
    }
}
