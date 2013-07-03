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

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use PMT\CoreBundle\Form\DataTransformer\MilestoneTransformer;
use PMT\CoreBundle\Form\DataTransformer\TagsTransformer;
use PMT\CoreBundle\Model\ProjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MilestoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text'
            )
            ->add(
                'dueDate',
                'datetime',
                array(
                    'required' => false,
                    'date_widget' => 'single_text',
                    'time_widget' => 'single_text',
                )
            );

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'PMT\CoreBundle\Entity\Project\Milestone',
            ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'milestone';
    }
}
