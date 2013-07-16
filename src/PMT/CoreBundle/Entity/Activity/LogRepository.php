<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\Entity\Activity;

use Doctrine\ORM\EntityRepository;
use MyProject\Proxies\__CG__\stdClass;
use PMT\CoreBundle\Entity\Comment\Comment;
use PMT\CoreBundle\Entity\Issue\Issue;
use PMT\CoreBundle\Entity\Project\Project;
use Symfony\Component\Security\Core\User\UserInterface;

class LogRepository extends EntityRepository
{
    public function getProjectLog(Project $project, $limit = 10)
    {
        return $this->getDashboardLog(null, $limit);
    }

    public function getDashboardLog(UserInterface $user = null, $limit = 10)
    {
        $dql = 'SELECT t FROM PMT\\CoreBundle\\Entity\\Activity\\Type t ';
        $types = $this->_em->createQuery($dql)
            ->getResult();

        if (!count($types)) {
            return array();
        }
        $select = array_map(function($type) {
                return 't' . $type->getId();
            }, $types);
        $dql = 'SELECT l, ' . implode(', ', $select) . ' FROM PMT\\CoreBundle\\Entity\\Activity\\Log l ';
        foreach ($types as $type) {
            $dql .= ' LEFT JOIN ' . $type->getName() . ' t' . $type->getId()
                . ' WITH l.sourceId = t' . $type->getId() . '.id AND l.sourceType = ' . $type->getId();
        }
        $dql .= ' ORDER BY l.timestamp DESC';

        $log = $this->_em->createQuery($dql)
            ->setMaxResults($limit)
            ->getResult();

        $length = count($log);
        $newLog = array();
        for ($i = 0; $i < $length; $i = $i + count($types)+1) {
            $newLog[$i] = $log[$i];
            //source
            for ($l = 1; $l <= count($types); $l++) {
                if ($log[$i + $l]) {
                    $newLog[$i]->source = $this->createReferenceObject($log[$i + $l]);
                }
            }
            if (!property_exists($newLog[$i], 'source')) {
                unset($newLog[$i]);
            }
        }

        return array_values($newLog);
    }

    protected function createReferenceObject($item)
    {
        $object = new \stdClass();
        $object->class = get_class($item);

        switch (get_class($item)) {
            case 'PMT\CoreBundle\Entity\Comment\Comment':
                $this->hydrateCommentReferenceObject($item, $object);
                break;
            case 'PMT\CoreBundle\Entity\Issue\Issue':
                $this->hydrateIssueReferenceObject($item, $object);
                break;
            default:
                var_dump($item);die;

        }

        return $object;
    }

    protected function hydrateIssueReferenceObject(Issue $item, &$object)
    {
        $object->label = $item->getProject()->getName() . ' - ' . $item->getSummary();
        $object->link = array(
            'route' => 'pmtweb_issue_detail',
            'args' => array(
                'projectCode' => $item->getProject()->getCode(),
                'id' => $item->getId(),
            ),
        );
    }

    protected function hydrateCommentReferenceObject(Comment $item, &$object)
    {
        $identifier = explode(':', $item->getThread()->getId());
        switch ($identifier[0]) {
            case 'issue':
                $item = $this->_em->getRepository('PMT\CoreBundle\Entity\Issue\Issue')
                    ->findOneBy(array(
                            'project' => $identifier[1],
                            'id' => $identifier[2],
                        ));
                $this->hydrateIssueReferenceObject($item, $object);
                break;
        }
    }
}
