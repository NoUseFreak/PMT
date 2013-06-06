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
    public function findCriticalForUser($user = null)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT i FROM PMT\\CoreBundle\\Entity\\Issue\\Issue i')
            ->setMaxResults(10)
            ->getResult();
    }
}
