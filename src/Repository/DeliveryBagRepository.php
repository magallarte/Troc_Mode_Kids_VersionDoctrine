<?php

namespace App\Repository;

use App\Entity\DeliveryBag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DeliveryBag|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryBag|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryBag[]    findAll()
 * @method DeliveryBag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryBagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DeliveryBag::class);
    }

//    /**
//     * @return DeliveryBag[] Returns an array of DeliveryBag objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeliveryBag
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
