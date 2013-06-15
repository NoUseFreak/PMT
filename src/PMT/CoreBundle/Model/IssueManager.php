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
use PMT\CoreBundle\Entity\Issue\Issue;

class IssueManager
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function saveIssue(Issue $issue)
    {
        if (!$issue->getCreated()) {
            $issue->setCreated(new \DateTime());

            $workflowManager = new WorkflowManager($this->em);

            $firstStep = $workflowManager->getFirstStep($issue->getProject()->getWorkflow());
            $issue->setStatus($firstStep->getStatus());
        }

        $issue->setLastUpdated(new \DateTime());

        $this->em->persist($issue);
        $this->em->flush();
    }
}
