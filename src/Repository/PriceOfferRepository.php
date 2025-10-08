<?php

namespace App\Repository;

use App\Entity\PriceOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PriceOffer>
 */
class PriceOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceOffer::class);
    }

        /**
         * @return PriceOffer[] Returns an array of PriceOffer objects
         */
        public function findAllOrderByNbrPerson(): array
        {
            return $this->createQueryBuilder('p')
                ->orderBy('p.numberPerson', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?PriceOffer
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
