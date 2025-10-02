<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateTicket', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Date :',
                'disabled' => true
            ])
            ->add('totalPrice', MoneyType::class, [
                'attr' => ['class' => 'form-control fs-3'],
                'label' => 'Total à payer :',
                'label_attr' => ['class' => 'form-label fs-3 text-primary'],
                'currency' => 'EUR',
                'disabled' => true
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-secondary btn-lg col-12 mx-auto m-4'],
                'label' => 'Payer'
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
