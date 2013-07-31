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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use FOS\UserBundle\Model\UserInterface;
use PMT\CoreBundle\Entity\Activity\Event;
use PMT\CoreBundle\Entity\Activity\Log;
use PMT\CoreBundle\Entity\Activity\Type;
use PMT\CoreBundle\Entity\Project\Project;
use PMT\CoreBundle\Entity\User;
use PMT\CoreBundle\Model\Activity\LoggableInterface;

class ActivityManager
{
    private $em;
    private $user;

    public function __construct(ObjectManager $em, UserInterface $user)
    {
        $this->em = $em;
        $this->user = $user;
    }

    public function log(User $user, $event, LoggableInterface $source, LoggableInterface $target = null)
    {
        $typeRepo = $this->em->getRepository('PMT\CoreBundle\Entity\Activity\Type');
        $eventRepo = $this->em->getRepository('PMT\CoreBundle\Entity\Activity\Event');

        $log = new Log();
        $log->setUser($user);
        $log->setSourceType($this->getType($typeRepo, $source));
        $log->setSourceId($source->getId());
        $log->setEvent($this->getEvent($eventRepo, $event));
        if ($target) {
            $log->setTargetType($this->getType($typeRepo, $target));
            $log->setTargetId($target->getId());
        }

        $this->em->persist($log);
        $this->em->flush();
    }

    private function getEvent(ObjectRepository $repo, $name)
    {
        $event = $repo->findOneBy(array(
                'name' => $name,
            ));
        if (!$event) {
            $event = new Event();
            $event->setName($name);
        }

        return $event;
    }

    private function getType(ObjectRepository $repo, $object)
    {
        $type = $repo->findOneBy(array(
                'name' => get_class($object),
            ));
        if (!$type) {
            $type = new Type();
            $type->setName(get_class($object));
        }

        return $type;
    }

    public function getProjectLog(Project $project)
    {
        return $this->em->getRepository('PMT\CoreBundle\Entity\Activity\Log')
            ->getProjectLog($project);
    }

    public function getDashboardLog()
    {
        return $this->em->getRepository('PMT\CoreBundle\Entity\Activity\Log')
            ->getDashboardLog($this->user);
    }
}
