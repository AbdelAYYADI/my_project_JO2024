<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Sport;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EventController extends AbstractController
{
    #[Route('/event/{sport}', name: 'app_event',  methods: ['GET'])]
    public function index(EntityManagerInterface $manager, Sport $sport): Response
    {
        $events = $manager->getRepository(Event::class)->findBy(['sport' => $sport]);
            
        return $this->render('event/event.html.twig', [
            'events' => $events,
            'sport' => $sport
        ]);
    }
}
