<?php

namespace App\Repository;

use App\Entity\DonationBag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DonationBag|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonationBag|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonationBag[]    findAll()
 * @method DonationBag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonationBagRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DonationBag::class);
    }

//    /**
//     * @return DonationBag[] Returns an array of DonationBag objects
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
    public function findOneBySomeField($value): ?DonationBag
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
