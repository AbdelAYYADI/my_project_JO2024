<?php

namespace App\Controller;

use App\Entity\Event;
use DateTimeImmutable;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Entity\PriceOffer;
use App\Service\PdfGenerator;
use App\Service\QrCodeGenerator;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\AssignOp\Concat;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class BookingController extends AbstractController
{

    #[Route('/booking/{event_id}', name: 'app_add_booking',  methods: ['POST', 'GET'])]
    public function addBooking(EntityManagerInterface $manager, Request $request, int $event_id): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $priceOffer = $manager->getRepository(PriceOffer::class)->findAll();
        $event      = $manager->getRepository(Event::class)->find($event_id);
        
        $booking = new Booking();
        
        if ( $user ) {
            $booking->setUser($user);
            $booking->setFullName($user->getFirstName().' '.$user->getLastName());        
        }
        $booking->setEvent($event);
        $booking->setNbrPerson(1);
        $booking->setNetPrice($event->getTicketPrice());
        $booking->setGrossPrice($event->getTicketPrice());
        $booking->setRateDiscount(0);
        $booking->setNetTotal($event->getTicketPrice());
        $booking->setBookDate(new DateTimeImmutable());
        $booking->setIsConfirmed(false);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        
        //Formulaire submitted and valide
        if ($form->isSubmitted() && $form->isValid()) {
            //dd($booking);
            $booking = $form->getData();
            
            $participants = $request->get('participantsNames'); // un tableau
            $booking->setPersonList($participants);

            if ($user === null) {
                $this->addFlash('warning', 'Identifiez-vous ou créez un compte');    
                return $this->redirectToRoute('app_add_booking', ['event_id'=>$event->getId()]);    
            }
            else {
                $this->addFlash('success', 'La réservation a été ajoutée à votre panier');
                $manager->persist($booking);
                $manager->flush();
                return $this->redirectToRoute('home.index');
            }

        }

        return $this->render('booking/booking.html.twig', [
            'formBooking' => $form,
            'event' => $event,
            'priceOffer' => $priceOffer
        ]);

    }

    #[Route('/booking', name: 'app_panier',  methods: ['POST', 'GET'])]
    public function showPanier(EntityManagerInterface $manager, Request $request): Response
    {
        $user = $this->getUser();
        $bookings = $manager->getRepository(Booking::class)->findByIsConfirmed($user, false);

        return $this->render('booking/panier.html.twig', [
            'bookings' => $bookings
        ]);
    }
    
    #[Route('/booking/delete/{id}', name: 'app_del_booking', methods: ['POST'])]
    public function deleteFromPanier(Request $request, EntityManagerInterface $manager, int $id, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $booking = $manager->getRepository(Booking::class)->find($id);

        if (!$booking) {
            throw $this->createNotFoundException('Réservation non trouvée ' . $id);
        }

        $token = new CsrfToken('delete' . $id, $request->request->get('_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            throw $this->createAccessDeniedException('Token CSRF invalide');
        }

        $manager->remove($booking);
        $manager->flush();

        $this->addFlash('success', 'La réservation a bien été supprimée');

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/booking-pdf/{id}', name: 'app_booking_pdf',  methods: ['POST', 'GET'])]
    public function generateBookingPdf(EntityManagerInterface $manager, PdfGenerator $pdf, QrCodeGenerator $qrCodeGenerator, int $id) : Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $booking = $manager->getRepository(Booking::class)->find($id);

        //$qrCode = $qrCodeGenerator->generateQrCode($booking->getBookingKey().'|'.$user->getSecurityKey()); 
        
        $html = $this->renderView('payment/bookingPdf.html.twig', [
                                    'booking' => $booking
                                    ]
                                );

        return new Response($pdf->showPfdFile($html, 'reservation-'.$booking->getId()), 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

}
