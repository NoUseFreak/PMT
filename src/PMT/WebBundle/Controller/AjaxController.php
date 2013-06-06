<?php

namespace PMT\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller
{
	/**
	 * @Route("/ajax/tags.json", name="ajax_tags")
	 * @Method("post")
	 */
	public function tagsAction()
	{
		$tags = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Tag')
			->findByName($this->getRequest()->request->get('q'));

		$tagObjects = array_map(
			function ($tag) {
				return array(
					'id' => $tag->getName(),
					'text' => $tag->getName(),
				);
			},
			$tags
		);

		if ($this->getRequest()->request->get('add_new')) {
			array_unshift(
				$tagObjects,
				array(
					'id' => $this->getRequest()->request->get('q'),
					'text' => 'new: ' . $this->getRequest()->request->get('q'),
				)
			);
		}

		$response = new JsonResponse();
		$response->setData(
			array(
				'tags' => $tagObjects,
			)
		);

		return $response;

	}
}
