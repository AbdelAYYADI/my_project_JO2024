<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function setUp(): void
    {

    }

    public function testEdit(): void {

        //Le user et password ci-dessous doivent exister dans la BDD de l'env.test
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
                    '_username' => 'abdel@gmail.com',
                    '_password' => 'Abdel@Jeux2024Paris'
        ]);

        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('abdel@gmail.com');
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/user/edit/'.$testUser->getId());
        $this->assertResponseIsSuccessful();
        //dd($crawler);
        $form = $crawler->selectButton('Modifier le compte')->form([
            'user[firstName]' => 'Abdel-Test',
            'user[lastName]' => 'Abdel-Test2',
            'user[lastName]' => '0102030405',
            'user[lastName]' => 'Abdel-Test2',
            'user[adress1]' => '10 - Rue la victoire',
            'user[postalCode]' => '75020',
            'user[city]' => 'Paris',
            'user[country]' => 'France',
        ]);

        $client->submit($form);

        // Assert redirected
        $this->assertResponseRedirects('/');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains('.alert.alert-success', 'Le compte a été modifié avec succès');
        $this->assertEquals('Abdel-Test', $testUser->getFirstName());

    }
}
