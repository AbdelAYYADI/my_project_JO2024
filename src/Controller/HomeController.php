<?php

namespace App\Controller;

use App\Entity\GamesHistory;
use App\Entity\Sport;
use App\Repository\SportRepository;
use App\Repository\GamesHistoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(EntityManagerInterface $manager): Response 
    {

        //$games = $this->repository->findAll();
        $games = $manager->getRepository(Sport::class)->findAll();
            
        return $this->render('home.html.twig', [
            'games' => $games
        ]);
    }

}      