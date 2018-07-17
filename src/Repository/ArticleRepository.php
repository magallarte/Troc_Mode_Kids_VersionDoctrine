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

    /**
     * @return Article[] Returns an array of Article objects
     */

    public function findByKid($kid)
    {
        $kidGender = $kid->getKidGender()->getId();
        $kidSizeCode=$kid->getKidSizeCode();

        return $this->createQueryBuilder('a')
            ->leftJoin('a.article_gender', 'g')
            ->addselect('g')
            ->leftJoin('a.article_size', 's')
            ->addselect('s')
            ->andWhere('a.article_gender= :kidgender')
            ->setParameter('kidgender', $kidGender)
            ->orWhere('a.article_gender= :mixedgender')
            ->setParameter('mixedgender', 3)
            ->andWhere('s.size_code= :kidsize')
            ->setParameter('kidsize', $kidSizeCode)
            ->andwhere('a.article_processStatus = :status')
            ->setParameter('status', '4' )
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

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
    public function findArticlesByMultipleSelection($selection): array
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.article_season', 's')
            ->addselect('s')
            ->leftJoin('a.article_color', 'c')
            ->addselect('c');
            
            $markers = array();
            $binds = array();
            foreach( $selection['Gender'] as $key=>$value) {
                $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':gender'.$key);
                $binds['gender'.$key] = $value; 
            }
            $qb->andWhere($qb->expr()->in('a.article_gender',$markers));

            $markers = array();
            foreach( $selection['Size'] as $key=>$value) {
                $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':size'.$key);
                $binds['size'.$key] = $value; 
            }
            $qb->andWhere($qb->expr()->in('a.article_size',$markers));

            $markers = array();
            foreach( $selection['Type'] as $key=>$value) {
                $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':type'.$key);
                $binds['type'.$key] = $value; 
            }
            $qb->andWhere($qb->expr()->in('a.article_type',$markers));

            $markers = array();
            foreach( $selection['Season'] as $key=>$value) {
                $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':season'.$key);
                $binds['season'.$key] = $value; 
            }
            $qb->andWhere($qb->expr()->in('s.id',$markers));

            $markers = array();
            foreach( $selection['Color'] as $key=>$value) {
                $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':color'.$key);
                $binds['color'.$key] = $value; 
            }
            $qb->andWhere($qb->expr()->in('c.id',$markers));

            $markers = array();
            foreach( $selection['Brand'] as $key=>$value) {
                $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':brand'.$key);
                $binds['brand'.$key] = $value; 
            }
            $qb->andWhere($qb->expr()->in('a.article_brand',$markers));

            $markers = array();
            foreach( $selection['WearStatus'] as $key=>$value) {
                $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':wearStatus'.$key);
                $binds['wearStatus'.$key] = $value; 
            }
            $qb->andWhere($qb->expr()->in('a.article_wearStatus',$markers));

            $markers = array();
            $markers[] = new \Doctrine\ORM\Query\Expr\Literal(':processStatus');
            $binds['processStatus']= '4';
            $qb->andWhere($qb->expr()->in('a.article_processStatus',$markers));

            $qb = $qb->orderBy('a.article_code', 'ASC')
            ->setParameters($binds)
            ->getQuery(); 
            
        return $qb->execute(); 

        // $sql = 'SELECT DISTINCT article.id FROM article
        // LEFT JOIN article_season ON article_season.article_id = article.id
        // LEFT JOIN season ON season.id = article_season.season_id
        // LEFT JOIN article_color ON article_color.article_id = article.id
        // LEFT JOIN color ON color.id = article_color.color_id
        // LEFT JOIN brand ON brand.id = article.article_brand_id
        // LEFT JOIN gender ON gender.id = article.article_gender_id
        // LEFT JOIN size ON size.id = article.article_size_id
        // LEFT JOIN type ON type.id = article.article_type_id
        // LEFT JOIN wear_status ON wear_status.id = article.article_wear_status_id
        // LEFT JOIN process_status ON process_status.id = article.article_process_status_id
        // ';
        
        // $selectionOptions = array('gender', 'size', 'type', 'color', 'season', 'brand', 'wear_status', 'process_status');
        
        // $markers = array();
        // $binds = array();
        
        // foreach ($selectionOptions as  $selectionOption) {
        //      if (!empty($selection[ucfirst($selectionOption)])) {
        //          foreach( $selection[ucfirst($selectionOption)] as $key=>$value) {
        //              $markers[] = 'article_'. $selectionOption.'_id = ?';
        //              $binds[] = $value; 
        //          }
        //      }
        // }
        
        // if (!empty($markers)) {
        //     $sql .= ' WHERE '.implode(' AND ', $markers);
        // }

        // if (!empty($binds)) {
        //     $binds .= implode(' && ', $binds);
        // }
        
        // $query = $bdd->prepare($sql);
        // $res = $query->execute($binds);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findArticlesByProcessStatus($processStatusId): array
    {
        $qb = $this->createQueryBuilder('a')
            ->andwhere('a.article_processStatus = :status')
            ->setParameter('status', $processStatusId )
            ->orderBy('a.article_code', 'ASC')
            ->getQuery();
            
        return $qb->execute(); 
    }
    
    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findArticlesToSellStatus(): array
    {
        $qb = $this->createQueryBuilder('a')
            ->andwhere('a.article_processStatus = :status')
            ->setParameter('status', '4' )
            ->orderBy('a.article_code', 'ASC')
            ->getQuery();
            
        return $qb->execute(); 
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findArticlesSelectedStatus(): array
    {
        $qb = $this->createQueryBuilder('a')
            ->andwhere('a.article_processStatus = :status')
            ->setParameter('status', '8' )
            ->orderBy('a.article_code', 'ASC')
            ->getQuery();
            
        return $qb->execute(); 
    }
}