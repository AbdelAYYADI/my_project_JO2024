<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Sport;
use App\Entity\Booking;
use App\Entity\Event;
use App\Entity\GamesHistory;
use App\Entity\Payment;
use App\Service\PdfGenerator;
use App\Service\QrCodeGenerator;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GamesHistoryRepository;
use App\Repository\StatsVentesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatsVentesController extends AbstractController
{

    #[Route('/stats-ventes', 'app_stats_ventes', methods: ['GET'])]
    public function showStatsVentes(EntityManagerInterface $manager): Response 
    {
        //$games = $this->repository->findAll();
        $games = $manager->getRepository(Sport::class)->findAll();
        
        $user = $this->getUser();
        $bookings = $manager->getRepository(Booking::class)->findByIsConfirmed($user, false);
            
        return $this->render('stats/menu-stats-ventes.html.twig', [
        ]);

    }

    #[Route('/stats-ventes-sport', name: 'app_stats_ventes_sport',  methods: ['POST', 'GET'])]
    public function showStatsVentesSport(EntityManagerInterface $manager, PdfGenerator $pdf) : Response
    {
        $ventes = $this->getStatsVentesSport($manager);        
        
        $html = $this->renderView('stats/stats-ventes-pdf.html.twig', [
                                    'ventes' => $ventes,
                                    'type_stats' => 'sport'
                                    ]
                                );
        
        return new Response($pdf->streamPdfFile($html, 'Stats-ventes-sport'), 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    #[Route('/stats-ventes-event', name: 'app_stats_ventes_event',  methods: ['POST', 'GET'])]
    public function showStatsVentesEvent(EntityManagerInterface $manager, PdfGenerator $pdf) : Response
    {
        $ventes = $this->getStatsVentesEvent($manager);        
        
        $html = $this->renderView('stats/stats-ventes-pdf.html.twig', [
                                    'ventes' => $ventes,
                                    'type_stats' => 'event'
                                    ]
                                );
        
        return new Response($pdf->streamPdfFile($html, 'Stats-ventes-event'), 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    #[Route('/stats-ventes-user', name: 'app_stats_ventes_user',  methods: ['POST', 'GET'])]
    public function getStatsVentesUser(EntityManagerInterface $manager, PdfGenerator $pdf) : Response
    {
        $ventes = $this->getStatsVenteUser($manager);        
        
        $html = $this->renderView('stats/stats-ventes-pdf.html.twig', [
                                    'ventes' => $ventes,
                                    'type_stats' => 'user',
                                    ]
                                );
        
        return new Response($pdf->streamPdfFile($html, 'Stats-ventes-user'), 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    #[Route('/stats-ventes-location', name: 'app_stats_ventes_location',  methods: ['POST', 'GET'])]
    public function showStatsVentesLocation(EntityManagerInterface $manager, PdfGenerator $pdf) : Response
    {
        $ventes = $this->getStatsVentesLocation($manager);        
        
        $html = $this->renderView('stats/stats-ventes-pdf.html.twig', [
                                    'ventes' => $ventes,
                                    'type_stats' => 'location',
                                    ]
                                );
        
        return new Response($pdf->streamPdfFile($html, 'Stats-ventes-lieu'), 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

    public function getStatsVenteUser(EntityManagerInterface $manager): array
        {
           $dql = '
                SELECT 
                    u.email AS email,
                    u.firstName AS first_name,
                    u.lastName AS last_name,
                    e.name AS event_name,
                    e.title AS title,
                    e.location AS location,
                    SUM(p.totalPrice) AS total,
                    SUM(b.nbrPerson) AS nbr_personnes
                FROM App\Entity\User u
                JOIN u.payments p
                JOIN p.bookings b
                JOIN b.event e
                GROUP BY u.email, u.firstName, u.lastName, e.name, e.title, e.location
                ORDER BY u.email, e.name, e.title, e.location
            ';

            $query = $manager->createQuery($dql);

            return $query->getResult();

        }

        public function getStatsVentesSport(EntityManagerInterface $manager): array
        {
           $dql = '
                SELECT 
                    e.name AS event_name,
                    e.title AS title,
                    SUM(p.totalPrice) AS total,
                    SUM(b.nbrPerson) AS nbr_personnes
                FROM App\Entity\Payment p
                JOIN p.bookings b
                JOIN b.event e
                GROUP BY e.name
                ORDER BY e.name
            ';

            $query = $manager->createQuery($dql);

            return $query->getResult();

        }

        public function getStatsVentesEvent(EntityManagerInterface $manager): array
        {
           $dql = '
                SELECT 
                    e.name AS event_name,
                    e.title AS title,
                    SUM(p.totalPrice) AS total,
                    SUM(b.nbrPerson) AS nbr_personnes
                FROM App\Entity\Payment p
                JOIN p.bookings b
                JOIN b.event e
                GROUP BY e.name, e.title
                ORDER BY e.name, e.title
            ';

            $query = $manager->createQuery($dql);

            return $query->getResult();

        }

        public function getStatsVentesLocation(EntityManagerInterface $manager): array
        {
           $dql = '
                SELECT 
                    e.name AS event_name,
                    e.title AS title,
                    e.location AS location,
                    SUM(p.totalPrice) AS total,
                    SUM(b.nbrPerson) AS nbr_personnes
                FROM App\Entity\Payment p
                JOIN p.bookings b
                JOIN b.event e
                GROUP BY e.name, e.title, e.location
                ORDER BY e.name, e.title, e.location
            ';

            $query = $manager->createQuery($dql);

            return $query->getResult();

        }


}      