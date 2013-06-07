<?php

namespace PMT\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * @Template()
     * @Route("/users/{username}", name="user_profile")
     */
    public function profileAction($username)
    {
        $user = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\User')
            ->findOneByUsername($username);

        if (!$user) {
            throw $this->createNotFoundException('The user could not be found');
        }

        return array(
            'user' => $user,
        );
    }
}