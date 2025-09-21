<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    //    /**
    //     * @return Booking[] Returns an array of Booking objects
    //     */
        public function findByIsConfirmed($user, $confirmed): array
        {
            return $this->createQueryBuilder('b')
                ->andWhere('b.user = :valUser')
                ->andWhere('b.isConfirmed = :valConfirmed')
                ->setParameter('valUser', $user)
                ->setParameter('valConfirmed', $confirmed)
                ->orderBy('b.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
         }

    //    public function findOneBySomeField($value): ?Booking
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
