<?php

namespace App\Form;

use App\Entity\EmergencyContacts;
use App\Entity\RelativeTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmergencyContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameEmergency', TextType::class, [
                'label' => 'Name ',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('mobileEmergency', TextType::class, [
                'label' => 'Tel',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('emailEmergency', EmailType::class, [
                'label' => 'Email',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('relativeType', EntityType::class, [
                'class' => RelativeTypes::class,
                'label' => 'Relative',
                'required' => true,
                'placeholder' => 'Please choose a value',
                'attr' => array('class' => 'form-control')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmergencyContacts::class,
        ]);
    }
}
