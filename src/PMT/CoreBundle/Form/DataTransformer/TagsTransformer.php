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
use Symfony\Component\Form\DataTransformerInterface;

class TagsTransformer implements DataTransformerInterface
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
     * @param  \Doctrine\Common\Collections\ArrayCollection $tags
     * @return string
     */
    public function transform($tags)
    {
        return implode(',', array_map(function($tag) {
            return $tag->getName();
        }, $tags->toArray()));
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param string $tags
     *
     * @return ArrayCollection|null
     */
    public function reverseTransform($tags)
    {
        $collection = new ArrayCollection();

        if (!$tags) {
            return null;
        }

        foreach (explode(',', $tags) as $tag) {
            $collection->add($this->om->getRepository('PMT\CoreBundle\Entity\Tag')->findOneByName($tag, true));
        }

        return $collection;
    }
}
