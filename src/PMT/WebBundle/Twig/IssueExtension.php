<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\WebBundle\Twig;

use PMT\CoreBundle\Entity\Issue\Issue;

class IssueExtension extends \Twig_Extension
{
    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'issue_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('issue_type_icon_class', array($this, 'typeIconClassFilter')),
            new \Twig_SimpleFilter('issue_priority_icon_class', array($this, 'typePriorityClassFilter')),
            new \Twig_SimpleFilter('issue_status_icon_class', array($this, 'typeStatusClassFilter')),
        );
    }

    public function typeIconClassFilter(Issue $issue)
    {
        return $this->createCssClass($issue->getType()->getName());
    }

    public function typePriorityClassFilter(Issue $issue)
    {
        return $this->createCssClass($issue->getPriority()->getName());
    }

    public function typeStatusClassFilter(Issue $issue)
    {
        return $this->createCssClass($issue->getStatus()->getName());
    }

    private function createCssClass($name)
    {
        return str_replace(' ', '_', strtolower($name));
    }

}
