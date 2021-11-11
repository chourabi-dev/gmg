<?php

namespace App\Form;

use App\Entity\Contracts;
use App\Entity\ContractTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ContractsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractType', EntityType::class, [
                
                'class' => ContractTypes::class,
                'label' => 'Contract Type',
                'required' => true,
                'placeholder' => 'Please choose a value',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid')
            ])
            ->add('contractPdf', FileType::class, [
                
                'label' => 'Contract ( PDF )',
                'mapped' => false,
                'required' => true,
                'attr'=>array('class'=>'form-control form-control-lg form-control-solid','placeholder'=>'', 'accept'=>'application/pdf' ),
                'constraints' => [
                    new File([
                        
                    ])
                ],
            ])
            ->add('contractDoc', FileType::class, [
                
                'label' => 'Contract ( DOC / DOCX )',
                'mapped' => false,
                'required' => true,
                'attr'=>array('class'=>'form-control form-control-lg form-control-solid','placeholder'=>'', 'accept'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword'),
                'constraints' => [
                    new File([
                        
                    ])
                ],
            ])
            ->add('DateStartContract', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'label' => 'Contract Start Date',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            ->add('DateEndContract', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Contract End Date',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            ->add('probation', NumberType::class, [
                
                'label' => 'Probation ( month )',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            ->add('noticePeriode', NumberType::class, [
                
                'label' => 'Notice period ( month )',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            
            ->add('salary', NumberType::class, [
                
                'label' => 'Salary',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            ->add('daysOff', NumberType::class, [
                
                'label' => 'Days Off',
                'attr' => array('class' => 'form-control form-control-lg form-control-solid', 'placeholder' => '')
            ])
            ->add('save', SubmitType::class, ['label' => 'create', 'row_attr' => [
                'class' => 'buttons-submit-group'
            ], 'attr' => array('class' => 'btn btn-primary mr-2')])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contracts::class,
        ]);
    }
}
