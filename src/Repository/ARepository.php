<?php

namespace App\Repository;

use App\Entity\A;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<A>
 */
class ARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, A::class);
    }

    /**
     * @return A[] Returns an array of A objects
     */
    public function findByUser($user): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.user_id = :id')
            ->andWhere('a.statut = :statut')
            ->setParameter('id', $user)
            ->setParameter('statut', 'validé')
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?A
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
