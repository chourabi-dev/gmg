<?php

namespace App\Form;

use App\Entity\ExpenseTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseTypesTypeEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('expenseType', TextType::class, [
                'label' => 'Expense type',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('update', SubmitType::class, ['label' => 'Update', 'row_attr' => [
                'class' => 'buttons-submit-group'
            ], 'attr' => array('class' => 'btn btn-primary mr-2')]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExpenseTypes::class,
        ]);
    }
}
