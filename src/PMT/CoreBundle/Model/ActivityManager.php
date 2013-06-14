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
use FOS\UserBundle\Model\UserInterface;
use PMT\CoreBundle\Entity\Activity\Event;
use PMT\CoreBundle\Entity\Activity\Log;
use PMT\CoreBundle\Entity\Activity\Type;

class ActivityManager
{
    private $em;
    private $user;

    public function __construct(ObjectManager $em, UserInterface $user)
    {
        $this->em = $em;
        $this->user = $user;
    }

    public function log($event, $source, $target = null)
    {
        $typeRepo = $this->em->getRepository('PMT\CoreBundle\Entity\Activity\Type');
        $eventRepo = $this->em->getRepository('PMT\CoreBundle\Entity\Activity\Event');

        $logEvent = $eventRepo->findOneBy(array(
            'name' => $event,
        ));
        if (!$logEvent) {
            $logEvent = new Event();
            $logEvent->setName($event);
        }
        $sourceType = $typeRepo->findOneBy(array(
            'name' => get_class($source),
        ));
        if (!$sourceType) {
            $sourceType = new Type();
            $sourceType->setName(get_class($source));
        }

        $log = new Log();
        $log->setUser($this->user);
        $log->setSourceType($sourceType);
        $log->setSourceId($source->getId());
        $log->setEvent($logEvent);

        $this->em->persist($log);
        $this->em->flush();
    }
}
