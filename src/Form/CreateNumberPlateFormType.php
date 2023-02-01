<?php

namespace App\Form;

use App\Entity\Carrier;
use App\Entity\NumberPlate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CreateNumberPlateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', TextType::class, [
                'label' => 'Numéro de plaque',
                'constraints' => [
                    new Length([
                        'min' => 9,
                        'minMessage' => 'N\'oubliez pas les tirets',
                        'max' => 9,
                        'maxMessage' => 'Erreur dans la saisie de la plaque'
                    ])
                ],
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control',

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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NumberPlate::class,
        ]);
    }
}
