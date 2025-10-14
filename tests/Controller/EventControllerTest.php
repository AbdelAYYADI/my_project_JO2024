<?php

namespace App\Tests\Controller;

use App\Entity\Event;
use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function setUp(): void
    {

    }

    public function testShowEventById(): void
    {
        $client = static::createClient();

        // Get the test container and doctrine
        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);

        $sport = $entityManager->getRepository(Sport::class)->find(3);

        $event = new Event();
        $event->setSport($sport);
        $event->setName('Football');
        $event->setTitle('Lundi 10 juillet');
        $event->setLocation('Parc des princes');
        $event->setTicketPrice(100);
        $event->setDateEvent(new \DateTimeImmutable());
        $event->setProgramEvent(['Match de poule A', '21h45 France - Epagne']);
        $entityManager->persist($event);
        $entityManager->flush();
        //dd($event);
        $client->request('GET', '/booking/' . $event->getId());

        $this->assertResponseIsSuccessful();
        $this->assertEquals('Football', $event->getName());
        $this->assertSelectorTextContains('h2', $event->getLocation());
    }
    
    public function testShowEventBySport(): void
    {
        $client = static::createClient();

        // Get the test container and doctrine
        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);

        $sport = $entityManager->getRepository(Sport::class)->find(3);
        $events = $entityManager->getRepository(Event::class)->findBy(['sport' => $sport]);

        $client->request('GET', '/event/' . $sport->getId());

        foreach ($events as $event) {
            $this->assertEquals($sport, $event->getSport());
        }

        $this->assertResponseIsSuccessful();
        $this->assertEquals($sport, $events[0]->getSport());
    }

}
