<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Booking;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    /**
     * @param User $user
     * @param bool $confirmed
     * @return Booking[]  // or whatever entity is being returned
     */
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

        public function getNetTotalSumByUser(User $user, bool $isConfirmed): ?float
        {
            $manager = $this->getEntityManager();
            $query = $manager->createQuery(
                'SELECT SUM(b.netTotal)
                FROM App\Entity\Booking b
                WHERE b.user = :user AND b.isConfirmed = :isConfirmed'
            );
            $query->setParameter('user', $user);
            $query->setParameter('isConfirmed', $isConfirmed);

            return (float) $query->getSingleScalarResult(); // returns float|0.0
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
