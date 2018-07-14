<?php

namespace App\Repository;

use App\Entity\ProcessStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProcessStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessStatus[]    findAll()
 * @method ProcessStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProcessStatus::class);
    }

//    /**
//     * @return ProcessStatus[] Returns an array of ProcessStatus objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProcessStatus
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
