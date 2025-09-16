<?php

namespace App\Form;

use Assert\NotNull;
use Assert\NotBlank;
use App\Entity\Booking;
use App\Entity\PriceOffer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class BookingType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {

        $builder
            ->add('nbrPerson', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => '1',
                    'max' => '4',
                ],
                'label' => 'Nombre de personnes *',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                ]
            ])
            ->add('fullName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '255',
                ],
                'label' => 'Nom complet de la personne principale *',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull(),
                ]
            ])
            ->add('rateDiscount', TextType::class, [
                'attr' => [
                    'class' => 'form-label',
                    'readonly' => true
                ],
                'label' => 'Réduction %'
                
            ])
            ->add('grossPrice', TextType::class, [
                'attr' => [
                    'class' => 'form-label',
                    'readonly' => true
                ],
                'label' => 'Prix Unitaire Brut'
            ])
            ->add('netPrice', TextType::class, [
                'attr' => [
                    'class' => 'form-label',
                    'readonly' => true
                ],
                'label' => 'Prix Unitaire Net'
            ])
            ->add('netTotal', TextType::class, [
                'attr' => [
                    'class' => 'form-label',
                    'readonly' => true
                ],
                'label' => 'Total Net'
            ])
            ->add('btnPanier', SubmitType::class, [
                'attr' => ['class' => 'm-1 btn btn-lg btn-secondary',
                           'style' => 'width: 100%'
                          ],
                'label' => 'Ajouter au panier'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }

}