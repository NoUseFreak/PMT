<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\Entity\Workflow;

use Doctrine\ORM\EntityRepository;

class WorkflowStepRepository extends EntityRepository
{
    public function findStartStep(Workflow $workflow)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT ws FROM PMT\\CoreBundle\\Entity\\Workflow\\WorkflowStep ws '
                . 'WHERE ws.workflow = :workflow AND ws.start = :start')
            ->setMaxResults(1)
            ->setParameters(array(
                    'workflow' => $workflow,
                    'start' => true,
                ))
            ->getOneOrNullResult();
    }
}
