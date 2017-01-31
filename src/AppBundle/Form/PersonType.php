<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PersonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('firstname', TextType::class, array(
				// 'attr' => ['class' => 'col-md-3'],
			))
			->add('lastname', TextType::class, array(
				// 'attr' => ['class' => 'col-md-3'],
			))
			/*
			->add('age', RangeType::class, array(
				'attr' => array(
					'min' => 4,
					'max' => 99,
				)
			))
			*/
			->add('age', ChoiceType::class, array(
				'placeholder' => 'Âge',
				'choices'  => range(0, 99),				
			))
			->add('reduction', ChoiceType::class, array(
				'choices'  => array(
					'Plein tarif' => 0,
					'Demi-tarif' => 1,
				)
			))
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Person'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_person';
    }


}
