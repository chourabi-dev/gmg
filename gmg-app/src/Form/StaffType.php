<?php

namespace App\Form;

use App\Entity\Departments;
use App\Entity\Locations;
use App\Entity\Staff;
use App\Entity\StaffTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //) Photo, Gender, FirstName, LastName, Date of birth, Nationality, Family status
        $builder
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'attr' => array('class' => 'form-control', 'placeholder' => ''),
                'choices'  => [
                    'Mr' => "Mr",
                    'Mrs' => 'Mrs',
                ],
            ])
            ->add('firstname', TextType ::class, [
                'label' => 'First Name',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('lastname', TextType ::class, [
                'label' => 'Last Name',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('DOB', TextType ::class, [
                'label' => 'Birth Day',
                'attr' => array('class' => 'form-control', 'placeholder' => '', "to-update-type-input"=>"date")
            ])
            ->add('extension', TextType ::class, [
                'label' => 'Extension',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('email', EmailType ::class, [
                'label' => 'Email',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('title', TextType ::class, [
                'label' => 'Title',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('department', EntityType::class, [
                'class' => Departments::class,
                'label' => 'Department',
                'required' => true,
                'placeholder' => 'Please choose a value',
                'attr' => array('class' => 'form-control')
            ])
            ->add('staffType', EntityType::class, [
                'class' => StaffTypes::class,
                'label' => 'Staff Type',
                'required' => true,
                'placeholder' => 'Please choose a value',
                'attr' => array('class' => 'form-control')
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}
