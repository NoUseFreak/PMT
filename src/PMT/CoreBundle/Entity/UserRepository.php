<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findOneByUsername($username)
    {
        $tag = $this->getEntityManager()
            ->createQuery('SELECT u FROM PMT\\CoreBundle\\Entity\\User u WHERE u.username = :username')
            ->setMaxResults(1)
            ->setParameter('username', $username)
            ->getOneOrNullResult();

        return $tag;
    }
}
