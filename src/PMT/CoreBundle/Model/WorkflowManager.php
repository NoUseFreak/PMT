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
use PMT\CoreBundle\Entity\Issue\Issue;
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
        $step = $this->getCurrentStep($workflow, $currentStatus);

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
        $step = $this->getCurrentStep($workflow, $currentStatus);

        $steps = new ArrayCollection();
        foreach ($step->getActions() as $action) {
            if ($action->getEndStep()->getOrder() < $step->getOrder()) {
                $steps->add($action->getEndStep());
            }
        }

        return $steps;
    }

    /**
     * @param Issue $issue
     * @param Status $currentStatus
     * @param \PMT\CoreBundle\Entity\Workflow\WorkflowStep $newStep
     * @internal param \PMT\CoreBundle\Entity\Workflow\WorkflowStep $step
     * @return \PMT\CoreBundle\Entity\Workflow\WorkflowStep Indicate if the step could be completed
     */
    public function setToStep(Issue $issue, Status $currentStatus, WorkflowStep $newStep)
    {
        $step = $this->getCurrentStep($issue->getProject()->getWorkflow(), $currentStatus);

        if (!$this->validateStep($step, $newStep)) {
            return false;
        }

        //TODO implement this

        return true;
    }

    /**
     * @param Workflow $workflow
     * @param Status $status
     * @return mixed
     */
    private function getCurrentStep(Workflow $workflow, Status $status)
    {
        foreach ($workflow->getSteps() as $step) {
            if ($step->getStatus() == $status) {
                return $step;
            }
        }
    }

    /**
     * @param WorkflowStep $currentStep
     * @param WorkflowStep $newStep
     * @return bool
     */
    private function validateStep(WorkflowStep $currentStep, WorkflowStep $newStep)
    {
        foreach ($currentStep->getActions() as $action) {
            if ($action->getEndStep() == $newStep) {
                return true;
            }
        }

        return false;
    }
}
