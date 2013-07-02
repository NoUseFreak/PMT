<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\CoreBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use PMT\CoreBundle\Entity\Project\Milestone;
use Symfony\Component\Form\DataTransformerInterface;

class MilestoneTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param mixed $milestone
     * @return string
     */
    public function transform($milestone)
    {
        if ($milestone) {
            return $milestone->getId();
        }

        return '';
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param int $milestoneId
     *
     * @return Milestone|null
     */
    public function reverseTransform($milestoneId)
    {
        return $this->om->getRepository('PMT\CoreBundle\Entity\Project\Milestone')->findOneBy(
            array(
                'id' => $milestoneId,
            )
        );
    }
}
