<?php

namespace App\Form;

use App\Entity\Frequentation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrequentationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('morningCount', IntegerType::class, [
                'label' => 'Usagers ce matin',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ])
            ->add('afternoonCount', IntegerType::class, [
                'label' => 'Usagers cette après-midi',
                'attr' => [
                    'placeholder' => '',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Frequentation::class,
        ]);
    }
}
