<?php

namespace App\Tests;

use App\Entity\Payment;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PaymentEntityTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->validator = self::getContainer()->get(ValidatorInterface::class);

    }

    public function testTotalPriceZero(): void {

        $payment = new Payment();

        $payment->setTotalPrice(0);
        $errors = $this->validator->validate($payment);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
            }
        }
        //Une erreur : le total doit être supérieur à 0
        $this->assertCount(1, $errors);

    }
 
    public function testTotalPriceGreaterThanZero(): void {

        $payment = new Payment();

        $payment->setTotalPrice(50);
        $errors = $this->validator->validate($payment);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
            }
        }
        //Une erreur : le total doit être supérieur à 0
        $this->assertCount(0, $errors);

    }

    public function testGetTotalPrice(): void {

        $payment = new Payment();

        $totalPrice = 150.25;
        $payment->setTotalPrice($totalPrice);
        
        $this->assertEquals($totalPrice, $payment->getTotalPrice());

    }

}
