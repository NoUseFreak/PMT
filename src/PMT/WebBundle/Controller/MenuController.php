<?php

namespace PMT\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MenuController extends Controller
{
	/**
	 * @Template()
	 */
	public function primaryAction()
    {
        return array();
    }
}
