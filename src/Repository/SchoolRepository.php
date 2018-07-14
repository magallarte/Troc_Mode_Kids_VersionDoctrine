<?php

namespace App\Repository;

use App\Entity\School;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method School|null find($id, $lockMode = null, $lockVersion = null)
 * @method School|null findOneBy(array $criteria, array $orderBy = null)
 * @method School[]    findAll()
 * @method School[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchoolRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, School::class);
    }
    /**
     * @return School[] Returns an array of School objects
     */

    public function findByCity($city)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.school_city = :val')
            ->setParameter('val', $city)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findOneByDirectorName($director_name): ?School
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.school_director_name = :val')
            ->setParameter('val', $director_name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
