<?php

namespace App\Form;

use App\Entity\Carrier;
use App\Entity\Extraction;
use App\Entity\Material;
use App\Entity\NumberPlate;
use JetBrains\PhpStorm\Immutable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExtractionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', IntegerType::class, [
                'label' => 'Nombre d\'unité',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])
            ->add('size', IntegerType::class, [
                'label' => 'm²',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])
            ->add('destination', TextType::class, [
                'label' => 'Destination',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])
            ->add('isEmergency', CheckboxType::class, [
                'label' => 'Urgence',
                'attr' => [
                    'placeholder' => '',
                    'class' => ''
                ]
            ])
            ->add('material', EntityType::class, [
                'label' => 'Matériau',
                'class' => Material::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('carrier', EntityType::class, [
                'label' => 'Transporteur',
                'class' => Carrier::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('numberPlate', EntityType::class, [
                'label' => 'Plaque d\'immatriculation',
                'class' => NumberPlate::class,
                'choice_label' => 'number',
                'multiple' => false,
                'expanded' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Extraction::class,
        ]);
    }
}
