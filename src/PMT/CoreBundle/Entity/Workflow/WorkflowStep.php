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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="workflow_steps")
 * @ORM\Entity(repositoryClass="PMT\CoreBundle\Entity\Workflow\WorkflowStepRepository")
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class WorkflowStep
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
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Workflow\Workflow")
     * @ORM\JoinColumn(name="workflow_id", referencedColumnName="id")
     */
    private $workflow;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Issue\Status")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="PMT\CoreBundle\Entity\Workflow\WorkflowStepAction", mappedBy="startStep")
     */
    private $actions;

    /**
     * @ORM\Column(type="integer", options={"default" = 0})
     *
     * @var int
     */
    private $order;

    /**
     * @ORM\Column(type="boolean", name="is_first", options={"default" = false})
     *
     * @var bool
     */
    private $start;

    /**
     * @ORM\Column(type="boolean", name="is_final", options={"default" = false})
     *
     * @var bool
     */
    private $final;

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
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $workflow
     */
    public function setWorkflow($workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * @return mixed
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param mixed $actions
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return WorkflowStepAction[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param boolean $final
     */
    public function setFinal($final)
    {
        $this->final = $final;
    }

    /**
     * @return boolean
     */
    public function isFinal()
    {
        return $this->final;
    }

    /**
     * @param boolean $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return boolean
     */
    public function isStart()
    {
        return $this->start;
    }
}
