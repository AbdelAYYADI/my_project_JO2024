<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstName('Abdel');
        $user->setLastName('AYYADI');
        $user->setAdress1('7 Résidence des Acacias');
        $user->setPostalCode('78360');
        $user->setCity('Montesson');
        $user->setCountry('FRANCE');
        $user->setEmail('abdel.ayyadi@gmail.com');
        $user->setPassword('Abdel');
        $user->setPlainPassword('Abdel');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        
        $user = new User();
        $user->setFirstName('Abdel1');
        $user->setLastName('AYYADI1');
        $user->setAdress1('17 Résidence des Acacias');
        $user->setPostalCode('78360');
        $user->setCity('Montesson');
        $user->setCountry('FRANCE');
        $user->setEmail('abdel.ayyadi@gyahoo.fr');
        $user->setPassword('Abdel1');
        $user->setPlainPassword('Abdel1');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $manager->flush();

    }
}
