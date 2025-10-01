<?php

namespace App\Controller;

use App\Entity\Payment;
use DateTimeImmutable;
use App\Entity\Booking;
use App\Form\PaymentType;
use App\Service\PdfGenerator;
use App\Service\QrCodeGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


final class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function payment(EntityManagerInterface $manager, Request $request): Response
    {
        $user  = $this->getUser();
        $payment = new Payment();
        $payment->setUser($user);
        $payment->setDateTicket(new \DateTimeImmutable());

        $total = $manager->getRepository(Booking::class)->getNetTotalSumByUser($user, false);
        $payment->setTotalPrice($total);

        $form = $this->createForm(PaymentType::class, $payment);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $payment = $form->getData();

            $manager->persist($payment);
            $manager->flush();

            $bookings = $manager->getRepository(Booking::class)->findByIsConfirmed($user, false);

            foreach ($bookings as $booking) {
                $booking->setPayment($payment);
                $booking->setIsConfirmed(true);
                $manager->persist($booking);
            }
            $manager->flush();

            $this->addFlash(
                'success',
                'Paiement validé avec succès'
            );

            return $this->redirectToRoute('home.index');

        }
            

        return $this->render('payment/payment.html.twig', [
           'user' => $user,
           'formPayment' => $form,
           'totalPrice' => $total
        ]);
    }

    #[Route('/commande', name: 'app_commande')]
    public function showCommandes(EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $commandes = $manager->getRepository(Payment::class)->findByUser($user);

        return $this->render('payment/commandes.html.twig', [
            'commandes' => $commandes
        ]);

    }

    #[Route('/commande-pdf/{id}', name: 'app_commande_pdf',  methods: ['POST', 'GET'])]
    public function generateCommandePdf(EntityManagerInterface $manager, PdfGenerator $pdf, QrCodeGenerator $qrCodeGenerator, int $id) : Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $commande = $manager->getRepository(Payment::class)->find($id);
        $bookings = $commande->getBookings();
        
        $qrCodes = [];
        foreach ($bookings as $booking) {
            $qrCodes[$booking->getId()] = $qrCodeGenerator->generateQrCode($booking->getBookingKey().'|'.$user->getSecurityKey()); 
        }
        //dd($qrCodes);
        $html = $this->renderView('payment/bookingPdf.html.twig', [
                                    'bookings' => $bookings,
                                    'qrCodes' => $qrCodes
                                    ]
                                );
        
        return new Response($pdf->streamPdfFile($html, 'Commande-'.$commande->getId()), 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

}
