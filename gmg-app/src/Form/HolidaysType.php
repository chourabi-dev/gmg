<?php

namespace App\Form;

use App\Entity\Countries;
use App\Entity\Holidays;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HolidaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'row_attr'=>array( 'class'=>'col-sm-6 ' ),
                'label' => 'Date',
                'attr' => array('class' => 'form-control', 'placeholder' => '')
            ])
            ->add('country', EntityType::class, [
                'class' => Countries::class,
                'label' => 'Country',
                'required' => true,
                'placeholder' => 'Please choose a value',
                'attr' => array('class' => 'form-control')
            ])
            

            
            ->add('title', TextType::class, [
                'row_attr'=>array( 'class'=>'col-sm-6 ' ),
                'label' => 'Title',
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
            'data_class' => Holidays::class,
        ]);
    }
}
