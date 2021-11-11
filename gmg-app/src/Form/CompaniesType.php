<?php

namespace App\Form;

use App\Entity\Companies;
use App\Entity\CompanyTypes;
use App\Entity\IndustryTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompaniesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companyName', TextType::class, [
                'label' => 'Company name',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '')
            ])
            ->add('industry', EntityType::class, [
                'class' => IndustryTypes::class,
                'label' => 'Industry',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '')
            ])
            ->add('companyType', EntityType::class, [
                'class' => CompanyTypes::class,
                'label' => 'Company type',
                'attr' => array('class' => 'form-control form-control-solid', 'placeholder' => '')
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Companies::class,
        ]);
    }
}
