<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'translation_domain' => false,
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-control-label'
                ],
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => 255,
                    ]),
                    new Email()
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class, 
                'translation_domain' => false,
                'first_options' => [
                    'label' => 'Hasło',
                    'label_attr' => [
                        'class' => 'form-control-label'
                    ],
                    'attr' => [
                        'placeholder' => 'Hasło',
                        'class' => 'form-control',
                    ]
                ],
                'second_options' => [
                    'label' => 'Powtórz hasło',
                    'label_attr' => [
                        'class' => 'form-control-label'
                    ],
                    'attr' => [
                        'placeholder' => 'Powtórz hasło',
                        'class' => 'form-control',
                    ]
                ],
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8,
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-lg btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}