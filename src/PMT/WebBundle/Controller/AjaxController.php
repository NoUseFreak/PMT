<?php

namespace PMT\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller
{
    /**
     * @Route("/ajax/tags.json", name="pmtweb_ajax_tags")
     * @Method("post")
     */
    public function tagsAction()
    {
        $term = trim($this->getRequest()->request->get('q'));

        $tags = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Tag')
            ->findByName($term);

        $tagObjects = array_map(
            function ($tag) {
                return array(
                    'id' => $tag->getName(),
                    'text' => $tag->getName(),
                );
            },
            $tags
        );

        if ($this->getRequest()->request->get('add_new') && !in_array($term, $tags)) {
            $tagObjects[] =
                array(
                    'id' => $term,
                    'text' => 'new: ' . $term,
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

    /**
     * @Route("/ajax/milestones.json", name="pmtweb_ajax_milestones")
     * @Method("post")
     */
    public function milestoneAction()
    {
        $params = array(
            'project' => $this->getRequest()->request->get('project_id'),
        );

        $milestones = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Project\Milestone')
            ->findBy(
                $params,
                array(
                    'dueDate' => 'ASC',
                )
            );

        $milestoneObjects = array_map(
            function ($milestone) {
                return array(
                    'id' => $milestone->getId(),
                    'text' => $milestone->getName(),
                );
            },
            $milestones
        );

        $response = new JsonResponse();
        $response->setData(
            array(
                'milestones' => $milestoneObjects,
            )
        );

        return $response;
    }
}
