<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class UserController extends AbstractController
{
    /** 
     * This controller edit profil user
     * @param User $user
     * @param Request  $request
     * @param ntityManagerInterface $manager
     * @return Response
     * 
     */
    #[Route('/user/edit/{id}', name: 'app_user', methods: ['GET', 'POST'])]
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {

        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le compte a été modifié avec succès'
            );

            return $this->redirectToRoute('home.index');
        }
        
        return $this->render('security/updateUser.html.twig', [
            'formUser' => $form
        ]);
    }
}
