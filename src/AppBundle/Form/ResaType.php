<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

// use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class ResaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder		
			->add('date', DateType::class, array(							
								
				'widget' => 'single_text',				
				'format' => 'dd/MM/yyyy',

				// 'widget' => 'single_text',
				// do not render as type="date", to avoid HTML5 date pickers
				// 'html5' => false,
				// add a class that can be selected in JavaScript
				// 'attr' => ['class' => 'js-datepicker'],
				
			))
			->add('typeResa', ChoiceType::class, array(
				'choices'  => array(
				'Journée entière' => 'F',
				'Demi-journée' => 'H',
				),
			))
			->add('persons', EntityType::class, [
				'class' => 'AppBundle:Person',
			])
			->add('persons', CollectionType::class, [
				'entry_type' => PersonType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'prototype' => true,
				// 'prototype_data' => 'New Tag Placeholder',
				
				'error_bubbling' => false,
				// 'by_reference' => false,
				// 'required' => true,
			])
			->add('email', TextType::class, array())
			->add('nom', TextType::class, array())
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Resa'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_resa';
    }


}
