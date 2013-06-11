<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\Entity\Issue;

use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository
{
    public function findCriticalForUser($user)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT i FROM PMT\\CoreBundle\\Entity\\Issue\\Issue i')
            ->setMaxResults(10)
            ->getResult();
    }

    public function findAllForUser($user)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT i FROM PMT\\CoreBundle\\Entity\\Issue\\Issue i WHERE i.creator = :user OR i.assignee = :user'
            )
            ->setParameter('user', $user)
            ->setMaxResults(10)
            ->getResult();
    }

    public function findAllForUserInStatus($user, $status)
    {
        if (is_numeric($status)) {
            $status = $this->getEntityManager()->getRepository('PMT\CoreBundle\Entity\Issue\Status')
                ->find($status);
        }

        return $this->getEntityManager()
            ->createQuery(
                'SELECT i FROM PMT\\CoreBundle\\Entity\\Issue\\Issue i'
                . ' WHERE (i.creator = :user OR i.assignee = :user) AND i.status = :status'
            )
            ->setParameters(
                array(
                    'user' => $user,
                    'status' => $status,
                )
            )
            ->setMaxResults(10)
            ->getResult();
    }
}
