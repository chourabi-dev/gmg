<?php

namespace App\Form;

use App\Entity\Allowances;
use App\Entity\AllowanceTypes;
use App\Repository\SettingsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AllowancesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $periodicitys = $options['periodicitys'];

        $fianlP = array();

        for ($i=0; $i < sizeof($periodicitys) ; $i++) { 
            $fianlP[$periodicitys[$i]]=$periodicitys[$i];
        }


        $builder
            ->add('allowanceType', EntityType::class, [
                
                'class' => AllowanceTypes::class,
                'label' => 'Allowance Type',
                'required' => true,
                'placeholder' => 'Please choose a value',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid')
            ])
            ->add('amount', NumberType::class, [
                'label' => 'Amount',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            ->add('dueDate', DateType::class, [
                'widget' => 'single_text',
                
                'label' => 'Due Date',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            ->add('periodicity', ChoiceType::class, [
                'label' => 'periodicity',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => ''),
                'choices'  => $fianlP
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Note',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('save', SubmitType::class, ['label' => 'create', 'row_attr' => [
                'class' => 'buttons-submit-group'
            ], 'attr' => array('class' => 'btn btn-primary mr-2')])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Allowances::class,
             // enable this type to accept a limited set of countries
             'periodicitys' => null,
        ]);
    }
}
