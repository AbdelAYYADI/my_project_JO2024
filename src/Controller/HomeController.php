<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Entity\Booking;
use App\Entity\GamesHistory;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\GamesHistoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class HomeController extends AbstractController
{

    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response 
    {
        //$games = $this->repository->findAll();
        $games = $manager->getRepository(Sport::class)->findAll();

        $user = $this->getUser();
        $bookings = $manager->getRepository(Booking::class)->findByIsConfirmed($user, false);
            
        return $this->render('home.html.twig', [
            'games' => $games,
            'bookings' => $bookings
        ]);
    

    }

}      