<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class UserPassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nouveau mot de passe',
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 20,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                    ]),
                    new PasswordStrength(
                        minScore: PasswordStrength::STRENGTH_STRONG,
                        message: 'Veuillez saisir un mot de passe fort, ex : Dupont@Jeux2024Paris',
                    )
                ],
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Nouveau mot de passe *',
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
                'label' => 'Modifier'
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
