<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\PriceOffer;
use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    #[Route('/event/{sport}', name: 'app_event',  methods: ['GET'])]
    public function showEventBySport(EntityManagerInterface $manager, Sport $sport): Response
    {
        $events = $manager->getRepository(Event::class)->findBy(['sport' => $sport]);
            
        return $this->render('event/event.html.twig', [
            'events' => $events,
            'sport' => $sport
        ]);
    }


    #[Route('/event/booking/{id}', name: 'app_eventById',  methods: ['GET', 'POST'])]
    public function showEventById(EntityManagerInterface $manager, int $id): Response
    {

        $event = $manager->getRepository(Event::class)->find($id);
        
        $priceOffer = $manager->getRepository(PriceOffer::class)->findAll();

        if (!$event) {
            throw $this->createNotFoundException('Evenement innexistant');
        }

        return $this->render('booking/booking.html.twig', [
            'event' => $event,
            'priceOffer' => $priceOffer
        ]);
    }


}
?>