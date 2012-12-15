<?php

namespace Db\DbBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\True;

/**
 * Generic form for deleting.
 */
class DeleteType extends AbstractType
{
	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('confirmation', 'checkbox', array('required' => false, 'label' => 'Potwierdź'))
		;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'delete';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDefaultOptions(array $options)
	{
		return array(
			'validation_constraint' => new Collection(array(
				'confirmation' => new True(),
			)),
		);
	}
}
