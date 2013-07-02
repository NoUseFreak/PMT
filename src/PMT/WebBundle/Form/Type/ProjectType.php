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
use PMT\CoreBundle\Form\DataTransformer\TagsTransformer;
use PMT\CoreBundle\Model\ProjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProjectType extends AbstractType
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
                'name',
                'text'
            )
            ->add(
                'code',
                'text'
            )
            ->add(
                'description',
                'textarea',
                array(
                    'required' => false,
                )
            )
            ->add(
                'creator',
                'entity',
                array(
                    'class' => 'PMT\CoreBundle\Entity\User',
                    'property' => 'username',
                    'data' => $this->options['activeUser'],
                )
            )
            ->add(
                'workflow',
                'entity',
                array(
                    'class' => 'PMT\CoreBundle\Entity\Workflow\Workflow',
                    'property' => 'name',
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
        return 'project';
    }
}
