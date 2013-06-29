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
use PMT\CoreBundle\Entity\Project\Project;
use Symfony\Component\Security\Core\User\UserInterface;

class LogRepository extends EntityRepository
{
    public function getProjectLog(Project $project, $limit = 10)
    {
        $dql = 'SELECT l, i FROM PMT\\CoreBundle\\Entity\\Activity\\Log l '
            . ' JOIN PMT\\CoreBundle\\Entity\\Issue\\Issue i WITH i.id = l.sourceId '
            . ' JOIN PMT\\CoreBundle\\Entity\\Project\\Project p WITH p.id = i.project '
            . ' WHERE p.id = :project'
            . ' ORDER BY l.timestamp DESC';

        $log = $this->_em->createQuery($dql)
            ->setMaxResults($limit)
            ->setParameters(
                array(
                    'project' => $project,
                )
            )->getResult();

        $length = count($log);
        for ($i = 0; $i < $length; $i = $i + 2) {
            $log[$i]->issue = $log[$i + 1];
            unset($log[$i + 1]);
        }

        return array_values($log);
    }

    public function getDashboardLog(UserInterface $user, $limit = 10)
    {
        $dql = 'SELECT l, i FROM PMT\\CoreBundle\\Entity\\Activity\\Log l '
            . ' JOIN PMT\\CoreBundle\\Entity\\Issue\\Issue i WITH i.id = l.sourceId '
            . ' JOIN PMT\\CoreBundle\\Entity\\Project\\Project p WITH p.id = i.project '
            . ' ORDER BY l.timestamp DESC';

        $log = $this->_em->createQuery($dql)
            ->setMaxResults($limit)
            ->getResult();


        $length = count($log);
        for ($i = 0; $i < $length; $i = $i + 2) {
            $log[$i]->issue = $log[$i + 1];
            unset($log[$i + 1]);
        }

        return array_values($log);
    }
}
