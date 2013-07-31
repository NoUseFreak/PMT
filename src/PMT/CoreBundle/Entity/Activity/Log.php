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

use Doctrine\ORM\Mapping as ORM;
use PMT\CoreBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="activity_log")
 * @ORM\Entity(repositoryClass="PMT\CoreBundle\Entity\Activity\LogRepository")
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Log
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
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Activity\Type", cascade={"persist"})
     * @ORM\JoinColumn(name="source_type", referencedColumnName="id")
     */
    private $sourceType;

    /**
     * @ORM\Column(name="source_id", type="integer")
     */
    private $sourceId;

    /**
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Activity\Event", cascade={"persist"})
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     *
     * @var Event
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="PMT\CoreBundle\Entity\Activity\Type", cascade={"persist"})
     * @ORM\JoinColumn(name="target_type", referencedColumnName="id", nullable=true)
     */
    private $targetType;

    /**
     * @ORM\Column(name="target_id", type="integer", nullable=true)
     */
    private $targetId;

    /**
     * @ORM\Column(type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $timestamp;

    /**
     * @param \PMT\CoreBundle\Entity\Activity\Event $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @return \PMT\CoreBundle\Entity\Activity\Event
     */
    public function getEvent()
    {
        return $this->event;
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
     * @param mixed $sourceId
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;
    }

    /**
     * @return mixed
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * @param mixed $sourceType
     */
    public function setSourceType($sourceType)
    {
        $this->sourceType = $sourceType;
    }

    /**
     * @return mixed
     */
    public function getSourceType()
    {
        return $this->sourceType;
    }

    /**
     * @param mixed $targetId
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;
    }

    /**
     * @return mixed
     */
    public function getTargetId()
    {
        return $this->targetId;
    }

    /**
     * @param mixed $targetType
     */
    public function setTargetType($targetType)
    {
        $this->targetType = $targetType;
    }

    /**
     * @return mixed
     */
    public function getTargetType()
    {
        return $this->targetType;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \PMT\CoreBundle\Entity\User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return \PMT\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
