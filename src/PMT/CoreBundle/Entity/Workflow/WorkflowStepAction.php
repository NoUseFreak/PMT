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

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="workflow_step_actions")
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class WorkflowStepAction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Workflow\WorkflowStep", inversedBy="actions")
     * @ORM\JoinColumn(name="start_step_id", referencedColumnName="id")
     */
    private $startStep;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Workflow\WorkflowStep")
     * @ORM\JoinColumn(name="end_step_id", referencedColumnName="id")
     */
    private $endStep;

    /**
     * @param mixed $endStep
     */
    public function setEndStep($endStep)
    {
        $this->endStep = $endStep;
    }

    /**
     * @return mixed
     */
    public function getEndStep()
    {
        return $this->endStep;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $startStep
     */
    public function setStartStep($startStep)
    {
        $this->startStep = $startStep;
    }

    /**
     * @return mixed
     */
    public function getStartStep()
    {
        return $this->startStep;
    }
}
