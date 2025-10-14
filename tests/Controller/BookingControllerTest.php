<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;
use App\Repository\EventRepository;

class BookingControllerTest extends WebTestCase
{
    public function testAddBookingAsAuthenticatedUser(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        // On simule la connexion avec le user dont l'id = 1
        $userRepository = $container->get(UserRepository::class);
        $testUser = $userRepository->find(1);
        $client->loginUser($testUser);

        // On récupère le premier évenement sportid id=1
        $eventRepository = $container->get(EventRepository::class);
        $event = $eventRepository->find(1);
        
        $this->assertNotNull($event, 'Test requires at least one event');

        // Request the booking page
        $crawler = $client->request('GET', '/booking/' . $event->getId());
        //dd($crawler);
        $this->assertResponseIsSuccessful();

        // Remplir le formulaire de réservation
        $form = $crawler->selectButton('Ajouter au panier')->form(); 
        //dd($form);
        $form['booking[nbrPerson]'] = 1;
        $form['booking[fullName]'] = 'Abdel';
        $form['booking[netPrice]'] = $event->getTicketPrice();
        $form['booking[grossPrice]'] = $event->getTicketPrice();
        $form['booking[rateDiscount]'] = 0;
        $form['booking[netTotal]'] = $event->getTicketPrice() * 1;

        $client->submit($form, ['booking[btnPanier]' => '']);
                 
        // REdirection avec succès
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains('.alert.alert-success', 'La réservation a été ajoutée à votre panier');
    }
}
