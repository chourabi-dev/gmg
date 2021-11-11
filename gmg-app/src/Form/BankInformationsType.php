<?php

namespace App\Form;

use App\Entity\BankInformations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BankInformationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bankName', TextType::class, [
                'label' => 'Bank Name',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('BankAddress', TextType::class, [
                'label' => 'Bank Address',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('acountNumber', TextType::class, [
                'label' => 'Acount Number',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('beneficiaryName', TextType::class, [
                'label' => 'beneficiary Name',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('swiftcode', TextType::class, [
                'label' => 'swift Code',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BankInformations::class,
        ]);
    }
}
