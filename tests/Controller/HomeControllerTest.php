<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomeRoute(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        dd($crawler);

        $this->assertResponseIsSuccessful();
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

    }
}
