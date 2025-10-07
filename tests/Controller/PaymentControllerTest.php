<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaymentControllerTest extends WebTestCase
{
    public function setUp(): void {

    }

    public function testAccessBooking(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/booking');

        $this->assertResponseIsSuccessful();

        //Test l'existance du titre Votre panier
        $this->assertSelectorTextContains('.bg-secondary-subtle', 'Votre panier');

        //Tester l'existance du lien <Continuer mes réservations> qui point sur home.index
        $linkCrawler = $crawler->selectLink('Continuer mes réservations');
        $link = $linkCrawler->link();
        $uri = $link->getUri();
        $this->assertStringContainsString('/', $uri);

    }

    public function testAccessPayment(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/booking');

        $this->assertResponseIsSuccessful();

        //Test l'existance du titre Votre panier
        $this->assertSelectorTextContains('.bg-secondary-subtle', 'Votre panier');

        //Tester l'existance du lien <Continuer mes réservations> qui point sur home.index
        $linkCrawler = $crawler->selectLink('Passer au paiement');
        $link = $linkCrawler->link();
        $uri = $link->getUri();
        $this->assertStringContainsString('/payment', $uri);

    }

}
