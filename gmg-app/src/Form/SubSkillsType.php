<?php

namespace App\Form;

use App\Entity\Skills;
use App\Entity\SubSkills;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubSkillsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
        $builder
            ->add('skill', EntityType::class, [
                'class' => Skills::class,
                'label' => 'Skill',
                'required' => true,
                'placeholder' => 'Please choose a value',
                'attr' => array('class' => 'form-control')
            ])
            ->add('subSkill', TextType::class, [
                'label' => 'Sub Skill',
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
            'data_class' => SubSkills::class,
        ]);
    }
}
