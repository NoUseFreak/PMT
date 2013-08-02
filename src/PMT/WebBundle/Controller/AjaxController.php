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

        return new JsonResponse(array(
            'tags' => $this->getTagsData($term),
        ));
    }

    private function getTagsData($term)
    {
        $tags = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Tag')->findByName($term);
        $tagObjects = array_map(function ($tag) {
                return array(
                    'id' => $tag->getName(),
                    'text' => $tag->getName(),
                );
            }, $tags);

        if ($this->getRequest()->request->get('add_new') && !in_array($term, $tags)) {
            $tagObjects[] = array(
                'id' => $term,
                'text' => 'new: ' . $term,
            );
        }

        return $tagObjects;
    }

    /**
     * @Route("/ajax/milestones.json", name="pmtweb_ajax_milestones")
     * @Method("post")
     */
    public function milestoneAction()
    {
        return new JsonResponse(array(
            'milestones' => $this->getMilestoneData(),
        ));
    }

    private function getMilestoneData()
    {
        $milestones = $this->getDoctrine()->getRepository('PMT\CoreBundle\Entity\Project\Milestone')
            ->findBy(
                array(
                    'project' => $this->getRequest()->request->get('project_id'),
                ),
                array(
                    'dueDate' => 'ASC',
                )
            );

        return array_map(function ($milestone) {
                return array(
                    'id' => $milestone->getId(),
                    'text' => $milestone->getName(),
                );
            }, $milestones);
    }
}
