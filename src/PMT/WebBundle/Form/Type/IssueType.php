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
use PMT\CoreBundle\Form\DataTransformer\TagsTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IssueType extends AbstractType
{
	protected $om;

	/**
	 * @param ObjectManager $om
	 */
	public function __construct(ObjectManager $om)
	{
		$this->om = $om;
	}


	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add(
				'project',
				'entity',
				array(
					'class' => 'PMT\CoreBundle\Entity\Project\Project',
					'property' => 'name',
					'empty_value' => 'Choose an project',
				)
			)
			->add(
				'type',
				'entity',
				array(
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
				'choice',
				array(
					'choices' => array('1' => 'Major', '2' => 'Normal'),
					'required' => true,
				)
			)
			->add(
				$builder->create('tags', 'text')
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
}