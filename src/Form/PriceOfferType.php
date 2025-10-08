<?php

namespace App\Form;

use App\Entity\PriceOffer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PriceOfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                    'attr' => [
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '30',
                ],
                'label' => 'Libellé',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\NotNull()
                ]
            ])
            ->add('numberPerson', IntegerType::class, [
                    'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nombre de participants',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                ]
            ])            
            ->add('rateDiscount', IntegerType::class, [
                    'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Taux de réduction %',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\GreaterThanOrEqual(0),
                ]
            ])            
            ->add('valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-secondary col-4 mx-auto mt-4'],
                'label' => 'Valider'
            ])       
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PriceOffer::class,
        ]);
    }
}
