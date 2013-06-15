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
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use PMT\CoreBundle\Entity\Issue\Issue;
use PMT\CoreBundle\Entity\Issue\Status;
use PMT\CoreBundle\Entity\Workflow\Workflow;
use PMT\CoreBundle\Entity\Workflow\WorkflowStep;

class WorkflowManager
{

    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Workflow $workflow
     * @return WorkflowStep
     */
    public function getFirstStep(Workflow $workflow)
    {
        return $this->em->getRepository('\PMT\CoreBundle\Entity\Workflow\WorkflowStep')
            ->findStartStep($workflow);
    }

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
     * @param WorkflowStep $newStep
     * @internal param \PMT\CoreBundle\Entity\Issue\Status $currentStatus
     * @internal param \PMT\CoreBundle\Entity\Workflow\WorkflowStep $step
     * @return WorkflowStep Indicate if the step could be completed
     */
    public function setToStep(Issue $issue, WorkflowStep $newStep)
    {
        $step = $this->getCurrentStep($issue->getProject()->getWorkflow(), $issue->getStatus());

        if (!$this->validateStep($step, $newStep)) {
            return false;
        }

        $issue->setStatus($newStep->getStatus());
        $this->em->flush();

        return true;
    }

    /**
     * @param Workflow $workflow
     * @param Status $status
     * @return null|WorkflowStep
     */
    private function getCurrentStep(Workflow $workflow, Status $status)
    {
        foreach ($workflow->getSteps() as $step) {
            if ($step->getStatus() == $status) {
                return $step;
            }
        }

        return null;
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
