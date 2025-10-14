<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\PriceOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PriceOfferControllerTest extends WebTestCase
{
    public function setUp(): void
    {

    }

    public function testShwoPriceOfferAll(): void
    {
        $client = static::createClient();

        // Simuler un utilisateur admin connecté
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);        
        $user = $userRepository->find(1);
        $user->setRoles(['ROLE_ADMIN']);
        $client->loginUser($user);

        // Appel de la route
        $crawler = $client->request('GET', '/price-offer');

        // Vérifie la réponse HTTP
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Vérifie que le champ table du template existe
        $this->assertSelectorExists('table'); 

        $this->assertGreaterThan(0, $crawler->filter('table tr')->count(), 'La table contient au moins une ligne');
    }    


    public function testAddPriceOffer(): void
    {
        $client = static::createClient();

        // Simuler un utilisateur admin connecté
        //$userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);        
        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $user = $entityManager->getRepository(User::class)->find(1);
        //$user = $userRepository->find(1);
        $user->setRoles(['ROLE_ADMIN']);
        $entityManager->persist($user);
        $entityManager->flush();        
        $client->loginUser($user);
        //dd($user);

        $crawler = $client->request('GET', '/price-offer-add');
        //dd($crawler);
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Valider')->form([
            'price_offer[name]' => 'Groupe-5',
            'price_offer[numberPerson]' => 7,
            'price_offer[rateDiscount]' => 15,
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/price-offer');

        $client->followRedirect();

        $this->assertSelectorExists('.alert.alert-success'); 
        $this->assertSelectorTextContains('.alert.alert-success', 'L\'offre a été ajoutée avec succès');
        
    }

    public function testDelPriceOffer(): void
    {
        $client = static::createClient();

        // Simuler un utilisateur admin connecté
        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);
        $user = $entityManager->getRepository(User::class)->find(1);
        $user->setRoles(['ROLE_ADMIN']);
        $entityManager->persist($user);
        $entityManager->flush();        
        $client->loginUser($user);
        //dd($user);

        //On supprime l'offre crée ci-dessus car le champ nbrPerson est unique
        $priceOffer = $entityManager->getRepository(PriceOffer::class)->findOneBy(['numberPerson' => 7]);
        $crawler = $client->request('GET', '/price-offer-del/'.$priceOffer->getId());
        $entityManager->remove($priceOffer);
        $entityManager->flush();

        //$this->assertResponseIsSuccessful();

        $this->assertResponseRedirects('/price-offer');

        $client->followRedirect();

        // Vérifie que le champ table du template existe
        $this->assertSelectorExists('table'); 
       
    }


}
