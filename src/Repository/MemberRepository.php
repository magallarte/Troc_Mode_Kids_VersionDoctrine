<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Member::class);
    }

//    /**
//     * @return Member[] Returns an array of Member objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Member
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    //     public function findAllSameRole($role): array
    // {
    //     $conn = $this->getEntityManager()->getConnection();

    //     $sql = '
    //         SELECT * FROM `member_role`
    //         INNER JOIN `member` ON `member`.`id`= `member_role`.`member_id`
    //         INNER JOIN `role` ON `role`.`id`= `member_role`.`role_id`
    //         WHERE `role`.`role_name` = :role
    //         ORDER BY `member`.`member_name` ASC
    //         ';
    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute(['role' => $role]);

    //     // returns an array of arrays (i.e. a raw data set)
    //     return $stmt->fetchAll();
    // }
    /**
     * @param $role
     * @return Member[]
     */
    public function findAllSameRole($role): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('m')
            ->innerJoin('m.member_role', 'r', 'WITH', 'r.role_name = :role')
            ->addselect('r')
            ->orderBy('m.member_name', 'ASC')
            ->setParameter('role', $role)
            ->getQuery();

        return $qb->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }
}
