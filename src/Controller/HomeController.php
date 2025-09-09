<?php

namespace App\Controller;

use App\Entity\GamesHistory;
use App\Repository\SportRepository;
use App\Repository\GamesHistoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    private SportRepository $repository;

    public function __construct(SportRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(): Response 
    {

        $games = $this->repository->findAll();
            
        return $this->render('home.html.twig', [
            'games' => $games
        ]);
    }

}      