<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityControllerTest extends WebTestCase
{
    public function setUp(): void
    {

    }
    
    public function testLoginWithBadEmail(): void {
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
                    '_username' => 'bademail@mail.com',
                    '_password' => 'paswword1234*xxxx'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testLoginWithBadPassword(): void {
    
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
                    '_username' => 'abdel@mail.com',
                    '_password' => 'paswword1234*xxxx'
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }
    
    public function testLoginSuccessfull(): void {

        //Le user et password ci-dessous doivent exister dans la BDD de l'env.test
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
                    '_username' => 'abdel@gmail.com',
                    '_password' => 'Abdel@Jeux2024Paris'
        ]);

        $client->submit($form);
        $client->followRedirect();
        $links = $crawler->filter('a.dropdown-item');
        
        $this->assertSelectorTextContains('a.dropdown-item', 'Voir mes commandes');
        $this->assertSelectorExists('a[href="/commande"]');
        $this->assertSelectorTextContains('a.nav-link', 'Abdel');        
        
    }

}
