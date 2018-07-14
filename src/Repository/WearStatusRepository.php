<?php

namespace App\Repository;

use App\Entity\WearStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WearStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method WearStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method WearStatus[]    findAll()
 * @method WearStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WearStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WearStatus::class);
    }

//    /**
//     * @return WearStatus[] Returns an array of WearStatus objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WearStatus
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
