<?php

namespace App\Form;

use App\Entity\FamilyStatusTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilyStatusTypesTypeEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('familyStatusType', TextType::class, [
                'label' => 'Family status type',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('update', SubmitType::class, ['label' => 'Update', 'row_attr' => [
                'class' => 'buttons-submit-group'
            ], 'attr' => array('class' => 'btn btn-primary mr-2')]);
        ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FamilyStatusTypes::class,
        ]);
    }
}
