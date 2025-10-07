<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{

    public function setUp(): void {

    }

    public function testHomeRoutes(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();

        //Tester si la pa ge d'acuueil contient un titre <h5> Bienvenu sur le site des Jeux Olympiques Paris-2024 </h5>
        $this->assertSelectorTextContains('h5', 'Bienvenu sur le site des Jeux Olympiques Paris-2024');

        //Tester si le lien "Se connecter" pointe bien sur l'URL "/login"
        $linkCrawler = $crawler->selectLink('Se connecter');
        $link = $linkCrawler->link();
        $uri = $link->getUri();
        $this->assertStringContainsString('/login', $uri);

        //Tester si le lien "Créer un compte" pointe bien sur l'URL "/registration"
        $linkCrawler = $crawler->selectLink('Créer un compte');
        $link = $linkCrawler->link();
        $uri = $link->getUri();
        $this->assertStringContainsString('/registration', $uri);

        //Tester l'existance de l'URL /login
        $crawler = $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        //Tester l'existance de l'URL /registration
        $crawler = $client->request('GET', '/registration');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        //Tester l'accès à la route /event/1 : les évenements sportif du sport id=1
        $crawler = $client->request('GET', '/event/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/booking/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

}

