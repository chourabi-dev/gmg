<?php

namespace App\Form;

use App\Entity\RelativeTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelativeTypesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('RelativeType', TextType::class, [
                'label' => 'Realative Type',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('save', SubmitType::class, ['label' => 'create', 'row_attr' => [
                'class' => 'buttons-submit-group'
            ], 'attr' => array('class' => 'btn btn-primary mr-2')])
            ->add('saveAndAdd', SubmitType::class, ['label' => 'create and add another', 'row_attr' => [
                'class' => 'buttons-submit-group'
            ], 'attr' => array('class' => 'btn btn-primary mr-2')]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RelativeTypes::class,
        ]);
    }
}
