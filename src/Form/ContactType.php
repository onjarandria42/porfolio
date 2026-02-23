<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Votre nom',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre nom']),
                    new Length([
                        'min' => 2,
                        'max' => 150,
                        'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre nom ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre nom complet'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre email']),
                    new Email(['message' => 'Veuillez entrer un email valide']),
                    new Length([
                        'max' => 150,
                        'maxMessage' => 'Votre email ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'votre@email.com'
                ]
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un sujet']),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le sujet doit faire au moins {{ limit }} caractères',
                        'maxMessage' => 'Le sujet ne peut pas dépasser {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sujet de votre message'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre message']),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Votre message doit faire au moins {{ limit }} caractères'
                    ])
                ],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 10,
                    'placeholder' => 'Votre message...'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'contact_form',
        ]);
    }
}
