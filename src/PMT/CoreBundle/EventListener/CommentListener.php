<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\EventListener;

use FOS\CommentBundle\Event\CommentEvent;
use PMT\CoreBundle\Model\ActivityManager;

class CommentListener
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }
    public function registerNewComment(CommentEvent $event)
    {
        $activityManager = new ActivityManager($this->em, $event->getComment()->getAuthor());
        $activityManager->log($event->getComment()->getAuthor(), 'commented', $event->getComment());
    }
}
