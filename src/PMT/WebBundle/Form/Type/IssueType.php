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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueType extends AbstractType
{
    protected $om;
    protected $options = array();

    /**
     * @param ObjectManager $om
     * @param array $options
     */
    public function __construct(ObjectManager $om, $options)
    {
        $this->om = $om;
        $this->options = $options;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'project',
                'entity',
                array(
                    'empty_value' => '',
                    'class' => 'PMT\CoreBundle\Entity\Project\Project',
                    'property' => 'name',
                )
            )
            ->add(
                $builder->create(
                    'milestone',
                    'text',
                    array(
                        'required' => false,
                    )
                )
                    ->addModelTransformer(new MilestoneTransformer($this->om))
            )
            ->add(
                'type',
                'entity',
                array(
                    'empty_value' => '',
                    'class' => 'PMT\CoreBundle\Entity\Issue\Type',
                    'property' => 'name',
                )
            )
            ->add('summary', 'text')
            ->add(
                'description',
                'textarea',
                array(
                    'required' => false,
                )
            )
            ->add(
                'priority',
                'entity',
                array(
                    'empty_value' => '',
                    'class' => 'PMT\CoreBundle\Entity\Issue\Priority',
                    'property' => 'name',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy('p.order', 'ASC');
                    },
                )
            )
            ->add(
                'creator',
                'entity',
                array(
                    'empty_value' => '',
                    'class' => 'PMT\CoreBundle\Entity\User',
                    'property' => 'username',
                    'data' => $this->options['activeUser'],
                )
            )
            ->add(
                $builder->create(
                    'tags',
                    'text',
                    array(
                        'required' => false,
                    )
                )
                    ->addModelTransformer(new TagsTransformer($this->om))
            );

    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'issue';
    }

    /**
     * Sets the default options for this type.
     *
     * @param OptionsResolverInterface $resolver The resolver for the options.
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
                'intention'  => 'issue_form',
            ));
    }
}
