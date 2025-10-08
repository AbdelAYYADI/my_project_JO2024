<?php

namespace App\Controller;

use App\Entity\PriceOffer;
use App\Form\PriceOfferType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PriceOfferController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN', message: 'Accès refusé')]
    #[Route('/price-offer', name: 'app_price_offer_index', methods: ['GET', 'POST'])]
    public function shwoPriceOfferAll(EntityManagerInterface $manager): Response
    {
        $priceOffers = $manager->getRepository(PriceOffer::class)->findAllOrderByNbrPerson();

        return $this->render('price_offer/priceofferIndex.html.twig', [
            'priceOffers' => $priceOffers,
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: 'Accès refusé')]
    #[Route('/price-offer/{id}', name: 'app_price_offer_show', methods: ['GET', 'POST'])]
    public function shwoPriceOffer(Request $request, EntityManagerInterface $manager, int $id): Response
    {
        $priceOffer = $manager->getRepository(PriceOffer::class)->find($id);

        $form = $this->createForm(PriceOfferType::class, $priceOffer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $priceOffer = $form->getData();
            $manager->persist($priceOffer);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'offre a été modifiée avec succès'
            );

            return $this->redirectToRoute('app_price_offer_index');
        }

        //dd($form);
        return $this->render('price_offer/priceofferShow.html.twig', [
            'priceOffer' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: 'Accès refusé')]
    #[Route('/price-offer-add', name: 'app_price_offer_add', methods: ['GET', 'POST'])]
    public function addPriceOffer(Request $request, EntityManagerInterface $manager): Response
    {
        $priceOffer = new PriceOffer();

        $form = $this->createForm(PriceOfferType::class, $priceOffer);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'offre a été ajoutée avec succès'
            );

            return $this->redirectToRoute('app_price_offer_index');
        }

        //dd($form);
        return $this->render('price_offer/priceofferShow.html.twig', [
            'priceOffer' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN', message: 'Accès refusé')]
    #[Route('/price-offer-del/{id}', name: 'app_price_offer_del', methods: ['GET', 'POST'])]
    public function delPriceOffer(Request $request, EntityManagerInterface $manager, int $id): Response
    {
        $priceOffer = $manager->getRepository(PriceOffer::class)->find($id);

        if (!$priceOffer) {
            throw $this->createNotFoundException('Offre non trouvée ' . $id);
        }

        if ($this->isCsrfTokenValid('delete' . $priceOffer->getId(), $request->request->get('_token'))) {
            $manager->remove($priceOffer);
            $manager->flush();

            $this->addFlash('success', 'L\'offre a été supprimée avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }        
            return $this->redirectToRoute('app_price_offer_index');
        }

}
