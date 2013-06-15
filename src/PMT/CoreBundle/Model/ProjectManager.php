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
use PMT\CoreBundle\Entity\Issue\Priority;
use PMT\CoreBundle\Entity\Project\Project;

class ProjectManager
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Project $project
     * @return Priority
     */
    public function getDefaultPriority(Project $project = null)
    {
        return $this->em->getRepository('\PMT\CoreBundle\Entity\Issue\Priority')
            ->findBy(
                array(
                    'order' => 0,
                )
            );
    }
}
