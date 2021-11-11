<?php

namespace App\Form;

use App\Entity\Agencies;
use App\Entity\Condidates;
use App\Entity\FamilyStatusTypes;
use App\Entity\SourceTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CondidatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First name',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '')
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last name',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '')
            ])
            ->add('dob', TextType::class, [
                'label' => 'Date of birth',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '', 'type' => 'date')
            ])
            
            ->add('otherExperience', TextareaType::class, [
                'label' => 'Other experience',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '', 'rows' => '3')
            ])
            
            ->add('agency', EntityType::class, [
                'class' => Agencies::class,
                'label' => 'Agency',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '')
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Condidates::class,
        ]);
    }
}
