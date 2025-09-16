<?php

namespace App\Controller;

use BookingType;
use App\Entity\user;
use App\Entity\Event;
use App\Entity\Booking;
use App\Entity\PriceOffer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;
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

            $booking = $form->getData();
            //dd($booking);
            //$booking->setNetPrice($event->getTicketPrice()*(1 - ));
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
    
}
