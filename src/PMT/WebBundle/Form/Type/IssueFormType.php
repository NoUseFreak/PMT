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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IssueFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('project', 'text')
			->add('type', 'text')
			->add('summary', 'text')
			->add(
				'priority',
				'choice',
				array(
					'choices' => array('1' => 'Major', '2' => 'Normal'),
					'required' => true,
				)
			)->add(
				'versions',
				'choice',
				array(
					'choices' => array('1' => 'v1', '2' => 'v2'),
					'required' => false,
					'multiple' => true
				)
			)
			->add('description', 'textarea')
			->add('labels', 'text')
			->add(
				'rebuild',
				'checkbox',
				array(
					'label' => 'Create another',
					'required' => false,
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
		return 'issue';
	}

}
