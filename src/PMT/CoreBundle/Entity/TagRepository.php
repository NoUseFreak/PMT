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

class TagRepository extends EntityRepository
{
	public function findOneByName($name, $create = false)
	{
		$tag = $this->getEntityManager()
			->createQuery('SELECT t FROM PMT\\CoreBundle\\Entity\\Tag t WHERE t.name = :name')
			->setMaxResults(1)
			->setParameter('name', $name)
			->getOneOrNullResult();

		if (!$tag && $create) {
			$tag = new Tag();
			$tag->setName($name);
			$this->getEntityManager()->persist($tag);
		}

		return $tag;
	}

	public function findByName($name, $limit = 10)
	{
		$tags = $this->getEntityManager()
			->createQuery('SELECT t FROM PMT\\CoreBundle\\Entity\\Tag t WHERE t.name LIKE :name ORDER BY t.name ASC')
			->setMaxResults($limit)
			->setParameter('name', '%' . $name . '%')
			->getResult();

		return $tags;
	}
}
