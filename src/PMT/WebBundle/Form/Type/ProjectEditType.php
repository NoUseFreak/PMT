<?php
/**
 * This file is part of the PMT package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PMT\WebBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class ProjectEditType extends ProjectType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add(
            'milestones',
            'collection',
            array(
                'type' => new MilestoneType(),
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'project_edit';
    }
}
