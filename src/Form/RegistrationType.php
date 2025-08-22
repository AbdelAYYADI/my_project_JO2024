<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '120',
                ],
                'label' => 'Nom *',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 120,
                        'minMessage' => 'Veuillez saisir au moins {{ limit }} caractères'
                    ]),
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '120',
                ],
                'label' => 'Prénom *',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 120,
                        'minMessage' => 'Veuillez saisir au moins {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('adress1', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '100',
                ],
                'label' => 'Adresse *',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 100,
                        'minMessage' => 'Veuillez saisir au moins {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('adress2', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '100',
                ],
                'label' => 'Complément d\'adresee',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'required' => false
                ])
            ->add('phoneNumber', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '10',
                    'maxlength' => '14',
                ],
                'label' => 'N° Téléphone *',
                    'label_attr' => [
                        'class' => 'form-label'
                    ],
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => ' /^0\d/',
                        'message' => 'Veuillez saisir un numéro de téléphone valide'
                    ]),
                   new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 10,
                        'max' => 14,
                        'minMessage' => 'Veuillez saisir un numéro de téléphone valide'
                    ])
                ]                
            ])
            ->add('postalCode', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '5',
                ],
                'label' => 'Code postal *',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 5,
                    ]),
                    new Assert\Regex([
                        'pattern' => ' /\d{5}/',
                        'message' => 'Veuillez saisir un code postal valide'
                    ]),
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '100',
                ],
                'label' => 'Ville *',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'Veuillez saisir au moins {{ limit }} caractères'

                    ])
                ]
            ])
            ->add('country', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '100',
                ],
                'label' => 'Pays *',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 100,
                        'minMessage' => 'Veuillez saisir au moins {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '5',
                    'maxlength' => '180',
                ],
                'label' => 'Email *',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez saisir une adresse mail valide']),
                    new Assert\NotNull(),
                    new Assert\Email(),
                    new Assert\Length([
                        'min' => 5,
                        'max' => 180
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 20,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                    ]),
                    /*
                    new PasswordStrength(
                        minScore: PasswordStrength::STRENGTH_STRONG,
                        message: 'Veuillez saisir un mot de passe fort',
                    )
                    */
                ],
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe *',
                    'label_attr' => [
                        'class' => 'form-label'
                    ]
                ],                
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmation du mot de passe *',
                    'label_attr' => [
                        'class' => 'form-label'
                    ]
                ],                
                'invalid_message' => 'Les mots de passe ne sont pas identiques'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-secondary col-12 mx-auto'],
                'label' => 'Créer le compte'
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
