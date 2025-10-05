<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Uid\Uuid;

class UserEntityTest extends KernelTestCase
{

    private const NOT_BLANK_MESSAGE = 'Veuillez saisir une valeur';
    
    private const VALID_EMAIL_VALUE = 'abdel.test@gmail.com';
    private const INVALID_EMAIL_VALUE = 'abdel@gmail';
    private const EMAIL_CONSTRAINT_MESSAGE = 'L\'email "abdel@gmail" n\'est pas valide';
    
    private const VALID_PASSWORD_VALUE = 'Dupont@Jeux2024Paris';
    private const INVALID_PASSWORD_VALUE = 'xxxxxxxxxx';
    private const PASSWORD_CONSTRAINT_MESSAGE = 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre, un caractère spécial et avoir au moins 10 caractères.';

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->validator = self::getContainer()->get(ValidatorInterface::class);

    }

    public function testUserEntityIsValid() {

        $user = new User();

        $user
            ->setFirstName('Abdel')
            ->setLastName('Abdel')
            ->setAdress1('7 Rue de la victoire')
            ->setPostalCode('75012')
            ->setCity('Paris')
            ->setCountry('FRANCE')
            ->setPhoneNumber('0658452564')
            ->setRoles(['ROLE_USER'])      
            ->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword(self::VALID_PASSWORD_VALUE)
            ->setIsAdmin(false);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
        }
    }
        $this->assertCount(0, $errors);
    }

    public function testUserEntityIsNotValid() {

        $user = new User();

        $user
            ->setFirstName('Abdel')
            ->setAdress1('7 Rue de la victoire')
            ->setPostalCode('75012')
            ->setCity('Paris')
            ->setCountry('FRANCE')
            ->setRoles(['ROLE_USER'])      
            ->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword(self::VALID_PASSWORD_VALUE)
            ->setIsAdmin(false);;

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
        }
    }
        //on s'attend à 4 erreurs : lastName(notblank, not null), phoneNumber(notblank, not null)
        $this->assertCount(4, $errors);
        $this->assertEquals(self::NOT_BLANK_MESSAGE, $errors[0]->getMessage());
    }

    public function testUserEmailIsNotValid() {

        $user = new User();

        $user
            ->setFirstName('Abdel')
            ->setLastName('Abdel')
            ->setAdress1('7 Rue de la victoire')
            ->setPostalCode('75012')
            ->setCity('Paris')
            ->setCountry('FRANCE')
            ->setPhoneNumber('0658452564')
            ->setRoles(['ROLE_USER'])      
            ->setEmail(self::INVALID_EMAIL_VALUE)
            ->setPassword(self::VALID_PASSWORD_VALUE)
            ->setIsAdmin(false);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
        }
    }
        $this->assertCount(1, $errors);
        $this->assertEquals(self::EMAIL_CONSTRAINT_MESSAGE, $errors[0]->getMessage());
    }


    public function testUserPasswordIsNotValid() {

        $user = new User();

        $user
            ->setFirstName('Abdel')
            ->setLastName('Abdel')
            ->setAdress1('7 Rue de la victoire')
            ->setPostalCode('75012')
            ->setCity('Paris')
            ->setCountry('FRANCE')
            ->setPhoneNumber('0658452564')
            ->setRoles(['ROLE_USER'])      
            ->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword(self::INVALID_PASSWORD_VALUE)
            ->setIsAdmin(false);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo sprintf("Property '%s': %s\n", $error->getPropertyPath(), $error->getMessage());
        }
    }
        $this->assertCount(1, $errors);
        $this->assertEquals(self::PASSWORD_CONSTRAINT_MESSAGE, $errors[0]->getMessage());
    }

}
