<?php

namespace App\Tests;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookingEntityTest extends KernelTestCase
{

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->validator = self::getContainer()->get(ValidatorInterface::class);

    }

    public function testBookingEntityIsValide() {

        $booking = new Booking();

        $booking
            ->setGrossPrice(100.25)
            ->setNetPrice(90)
            ->setNbrPerson(1)
            ->setNetTotal(1*90)
            ->setIsConfirmed(false)
            ->setFullName('Abdel');

        $errors = $this->validator->validate($booking);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
            }
        }
        $this->assertCount(0, $errors);

    }

    public function testBookingEntityIsNotValide() {

        $booking = new Booking();

        $booking
            ->setGrossPrice(100.25)
            ->setNetPrice(90)
            ->setNbrPerson(1)
            ->setNetTotal(1*90)
            ->setIsConfirmed(false);

        $errors = $this->validator->validate($booking);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
            }
        }
        //on s'attend à 2 erreurs : fullName(notblank, not null)
        $this->assertCount(2, $errors);
        $this->assertEquals('Veuillez saisir le nom complet', $errors[0]->getMessage());
    }

    public function testBookingEntityNbrPersonIsNotValide() {

        $booking = new Booking();

        $booking
            ->setGrossPrice(100.25)
            ->setNetPrice(90)
            ->setNbrPerson(0)
            ->setNetTotal(1*90)
            ->setIsConfirmed(false)
            ->setFullName('Abdel');

        $errors = $this->validator->validate($booking);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
            }
        }
        //On s'attend à 2 erreurs : nbrPerson=0 et netTotal <> netPrice*nbrPerson
        $this->assertCount(2, $errors);

    }

    public function testBookingEntityTotalPriceIsValide() {

        $booking = new Booking();

        $booking
            ->setGrossPrice(100.25)
            ->setNetPrice(90)
            ->setNbrPerson(2)
            ->setNetTotal(2*90)
            ->setFullName('Abdel')
            ->setIsConfirmed(false);

        $errors = $this->validator->validate($booking);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
            }
        }
        
        $this->assertCount(0, $errors);
    }

    public function testBookingEntityTotalPriceIsNotValide() {

        $booking = new Booking();

        $booking
            ->setGrossPrice(100.25)
            ->setNetPrice(90)
            ->setNbrPerson(2)
            ->setNetTotal(200)
            ->setFullName('Abdel')
            ->setIsConfirmed(false);

        $errors = $this->validator->validate($booking);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
            }
        }
        
        $this->assertCount(1, $errors);
        $this->equalTo('Le Net Total doit être égal au prix net unitaire multiplié par le nombre de personnes.', $errors[0]->getMessage());
    }

}
