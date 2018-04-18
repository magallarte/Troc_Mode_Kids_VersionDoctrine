<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return $article
     */
    public function findLastInsertedArticleId($criteria): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        // $qb = $this->createQueryBuilder('p')
        //     ->andWhere('p.article_gender = $criteria['gender']')
        //     ->orderBy('p.id', 'ASC')
        //     ->setMaxResults(1)
        //     ->getQuery();

        // return $qb->execute();

        // to get just one result:
        // $article = $qb->setMaxResults(1)->getOneOrNullResult();
    }

    
    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findAllWithAllDetails(): array
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.article_season', 's')
            ->addselect('s')
            ->leftJoin('a.article_color', 'c')
            ->addselect('c')
            ->leftJoin('a.article_fabric', 'f')
            ->addselect('f')
            ->orderBy('a.id', 'ASC');
            
        return $qb->getQuery()->getResult();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findArticlesByMultipleSelection($selection): array
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.article_season', 's', 'WITH', 's.id = :season')
            ->addselect('s')
            ->setParameter( 'season', array ($selection['Season']))
            ->innerJoin('a.article_color', 'c', 'WITH', 'c.id = :color')
            ->addselect('c')
            ->setParameter( 'color', $selection['Color']);
            // ->leftJoin('a.article_season', 's')
            // ->addselect('s')
            // ->leftJoin('a.article_color', 'c')
            // ->addselect('c');
            
            // foreach ($selection as $field => $selectionvalue)
            // {
            //     foreach ($selectionvalue as $key => $subselectionvalue)
            //     {
            //         $qb->andWhere(sprintf('a.article%s = :%s', '_'.strtolower($field), $field))
            //         ->setParameter($field, $subselectionvalue);
            //     }
            // }
        //$qb->andWhere($qb->expr()->in('region.id',$regions))
        //$qb->setParameters(array(1 => 'value for ?1', 2 => 'value for ?2'));

            $qb->andWhere($qb->expr()->in('a.article_gender',$selection['Gender']));
            $qb->andWhere($qb->expr()->in('a.article_size',$selection['Size']));
            $qb->andWhere($qb->expr()->in('a.article_type',$selection['Type']));
            // $qb->andWhere($qb->expr()->in('article_season.season_id',$selection['Season']));
            // $qb->andWhere($qb->expr()->in('article_color.color_id',$selection['Color']));
            $qb->andWhere($qb->expr()->in('a.article_brand',$selection['Brand']));
            $qb->andWhere($qb->expr()->in('a.article_wearStatus',$selection['WearStatus']));
            
            $qb = $qb->orderBy('a.article_code', 'ASC')
            ->getQuery();

            //  return $qb->getQuery()->getResult();
            
        return $qb->execute(); 
        // return $qb->getResult();
    }
}
