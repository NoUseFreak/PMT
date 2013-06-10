<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use PMT\CoreBundle\Entity\Issue\Status;
use PMT\CoreBundle\Entity\Workflow\Workflow;
use PMT\CoreBundle\Entity\Workflow\WorkflowStep;

class WorkflowManager
{
    /**
     * @param Workflow $workflow
     * @param Status $currentStatus
     * @return WorkflowStep[]
     */
    public function getNextSteps(Workflow $workflow, Status $currentStatus)
    {
        foreach ($workflow->getSteps() as $step) {
            if ($step->getStatus() == $currentStatus) {
                break;
            }
        }

        $steps = new ArrayCollection();
        foreach ($step->getActions() as $action) {
            if ($action->getEndStep()->getOrder() > $step->getOrder()) {
                $steps->add($action->getEndStep());
            }
        }

        return $steps;
    }

    /**
     * @param Workflow $workflow
     * @param Status $currentStatus
     * @return Status[]
     */
    public function getPreviousSteps(Workflow $workflow, Status $currentStatus)
    {
        foreach ($workflow->getSteps() as $step) {
            if ($step->getStatus() == $currentStatus) {
                break;
            }
        }

        $steps = new ArrayCollection();
        foreach ($step->getActions() as $action) {
            if ($action->getEndStep()->getOrder() < $step->getOrder()) {
                $steps->add($action->getEndStep());
            }
        }

        return $steps;
    }
}
