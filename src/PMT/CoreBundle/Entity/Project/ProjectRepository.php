<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\Entity\Project;

use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
	public function findAllForUser($user = null)
	{
		return $this->getEntityManager()
			->createQuery('SELECT p FROM PMT\\CoreBundle\\Entity\\Project\\Project p ORDER BY p.name ASC')
			->getResult();
	}

	public function findByCode($code)
	{
		return $this->getEntityManager()
			->createQuery('SELECT p FROM PMT\\CoreBundle\\Entity\\Project\\Project p WHERE p.code = :code')
			->setParameter('code', $code)
			->getOneOrNullResult();
	}
}
