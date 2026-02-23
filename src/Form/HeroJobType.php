<?php

namespace App\Form;

use App\Entity\HeroJob;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HeroJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Métier / Titre',
                'attr' => [
                    'placeholder' => 'Ex: Développeur Web, Designer, etc.'
                ]
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Position',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ordre d\'affichage'
                ]
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HeroJob::class,
        ]);
    }
}
