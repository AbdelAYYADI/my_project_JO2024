<?php

namespace App\Tests;

use App\Entity\Booking;
use App\Repository\UserRepository;
use App\Repository\EventRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertEquals;

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

    public function testPayment(): void {
        
        $client = static::createClient();
        $container = static::getContainer();

        // Simulate logging in as a test user
        $userRepository = $container->get(UserRepository::class);
        $testUser = $userRepository->find(1);

        $client->loginUser($testUser);

        // Request to the payment route
        $crawler = $client->request('GET', '/payment');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form[name=payment]');        

        // Submit the form
        $form = $crawler->selectButton('Payer')->form(); // Button name should match your template

        // Remplir le formulaire de paiement
        $form['payment[dateTicket]'] = (new DateTimeImmutable())->format('Y-m-d H:i');
        $form['payment[totalPrice]'] = 100;

        $client->submit($form);

        // Follow redirection
        $client->followRedirect();

        $this->assertSelectorTextContains('.alert.alert-success', 'Paiement validé avec succès');
        $this->assertRouteSame('home.index');
    }

}
