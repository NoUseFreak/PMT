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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="projects", uniqueConstraints={@ORM\UniqueConstraint(name="code_idx", columns={"code"})})
 * @ORM\Entity(repositoryClass="PMT\CoreBundle\Entity\Project\ProjectRepository")
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Project
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var string
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="PMT\CoreBundle\Entity\Issue\Issue", mappedBy="project")
     */
    private $issues;

    /**
     * @ORM\OneToMany(targetEntity="PMT\CoreBundle\Entity\Project\Milestone", mappedBy="project", cascade={"persist"})
     */
    private $milestones;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $creator;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Workflow\Workflow")
     * @ORM\JoinColumn(name="workflow_id", referencedColumnName="id")
     */
    private $workflow;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $description;

    public function __construct()
    {
        $this->issues = new ArrayCollection();
        $this->milestones = new ArrayCollection();
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
     * @param mixed $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return mixed
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * @param mixed $issues
     */
    public function setIssues($issues)
    {
        $this->issues = $issues;
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
     * @param mixed $milestones
     */
    public function setMilestones($milestones)
    {
        $this->milestones = $milestones;
    }

    /**
     * @return mixed
     */
    public function getMilestones()
    {
        return $this->milestones;
    }

    public function addMilestone(Milestone $milestone)
    {
        $milestone->setProject($this);

        $this->milestones->add($milestone);
    }

    public function removeMilestone($milestone)
    {
        $this->milestones->removeElement($milestone);
    }
}
