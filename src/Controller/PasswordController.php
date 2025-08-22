<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPassword;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class PasswordController extends AbstractController
{
    #[Route('/user/password/{id}', name: 'app_password', methods: ['GET', 'POST'])]
    public function password(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher): Response
    {

        

        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if($this->getUser() !== $user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserPassword::class, $user);
        
        $form->handleRequest($request);

        //Formulaire submitted but not valide
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPlainPassword());
            $user->setPassword($hashedPassword);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le mot de passe a été modifié avec succès'
            );

            return $this->redirectToRoute('home.index');
        }

        return $this->render('user/updatePassword.html.twig', [
            'formPassword' => $form
        ]);
    }
}
