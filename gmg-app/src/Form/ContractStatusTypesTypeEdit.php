<?php

namespace App\Form;

use App\Entity\ContractStatusTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractStatusTypesTypeEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contractStatusType', TextType::class, [
                
                'label' => 'Contract Status Type',
                'attr' => array('class' => 'form-control form-control-lg ', 'placeholder' => '')
            ])
            ->add('ordre', IntegerType::class, [
                
                'label' => 'Ordre',
                'attr' => array('class' => 'form-control form-control-lg ', 'placeholder' => '')
            ])
            ->add('update', SubmitType::class, ['label' => 'update', 'row_attr' => [
                'class' => 'buttons-submit-group'
            ], 'attr' => array('class' => 'btn btn-primary mr-2')]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContractStatusTypes::class,
        ]);
    }
}
