<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PasswordControllerTest extends WebTestCase
{
    public function setUp(): void
    {

    }

    public function testPassword() {

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
        //dd($testUser);
        
        $crawler = $client->request('GET', '/user/password/'.$testUser->getId());
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form([
            'user_password[plainPassword][first]' => 'Abdel@Jeux2024PariX',
            'user_password[plainPassword][second]' => 'Abdel@Jeux2024PariX',
        ]);

        $client->submit($form);

        // Assert redirected
        $this->assertResponseRedirects('/');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains('.alert.alert-success', 'Le mot de passe a été modifié avec succès');

    }        


    public function testPasswordBis() {

        //Ce tets pour remettre l'ancien mot de passe modifié ci-dessus

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
        //dd($testUser);
        
        $crawler = $client->request('GET', '/user/password/'.$testUser->getId());
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Modifier')->form([
            'user_password[plainPassword][first]' => 'Abdel@Jeux2024Paris',
            'user_password[plainPassword][second]' => 'Abdel@Jeux2024Paris',
        ]);

        $client->submit($form);

        // Assert redirected
        $this->assertResponseRedirects('/');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains('.alert.alert-success', 'Le mot de passe a été modifié avec succès');

    }
    
}
