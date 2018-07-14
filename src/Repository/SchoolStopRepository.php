<?php

namespace App\Repository;

use App\Entity\SchoolStop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SchoolStop|null find($id, $lockMode = null, $lockVersion = null)
 * @method SchoolStop|null findOneBy(array $criteria, array $orderBy = null)
 * @method SchoolStop[]    findAll()
 * @method SchoolStop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolStopRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SchoolStop::class);
    }

//    /**
//     * @return SchoolStop[] Returns an array of SchoolStop objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SchoolStop
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
