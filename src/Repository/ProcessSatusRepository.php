<?php

namespace App\Repository;

use App\Entity\ProcessSatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProcessSatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcessSatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcessSatus[]    findAll()
 * @method ProcessSatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcessSatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProcessSatus::class);
    }

//    /**
//     * @return ProcessSatus[] Returns an array of ProcessSatus objects
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
    public function findOneBySomeField($value): ?ProcessSatus
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
