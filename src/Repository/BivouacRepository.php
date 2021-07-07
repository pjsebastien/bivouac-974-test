<?php

namespace App\Repository;

use App\Entity\Bivouac;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bivouac|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bivouac|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bivouac[]    findAll()
 * @method Bivouac[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BivouacRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bivouac::class);
    }
    /**
     * Recherche d'un bivouac en fonction d'un formulaire
      *@return void
    */
    public function search($mots = null, $categorie = null, $region = null){
        $query = $this->createQueryBuilder('b');
        $query->where('b.active =1');
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(b.title, b.content) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }
        if($categorie != null){
            $query->leftJoin('b.Categories', 'c');
            $query->andWhere('c.id = :id')
                ->setParameter('id', $categorie);
        }
        // if($region != null){
        //     $query->leftJoin('b.regions', 'r');
        //     $query->andWhere('r.id = :id')
        //         ->setParameter('id', $region);
        // }

        return $query->getQuery()->getResult();
    }

    /**
     * Returns all bivouac per page
     * @return void
     */
    public function getPaginatedBivouac($page, $limit, $filtersCat = null){
        $query = $this->createQueryBuilder('b')
            ->where('b.active=1');
        //On filtre les données
        if($filtersCat != null){
            $query->andWhere('b.Categories IN(:cats)')
                ->setParameter(':cats', array_values($filtersCat));
        }

        $query->orderBy('b.created_at')
            ->setFirstResult(($page * $limit) -$limit)
            ->setMaxResults($limit);
        
        return $query->getQuery()->getResult();
    }
    /**
     * Returns number of bivouac
     * @return void
     */
    public function getTotalBivouac($filtersCat= null){
        $query = $this->createQueryBuilder('b')
            ->select('COUNT(b)')
            ->where('b.active=1');
            //On filtre les données
        if($filtersCat != null){
            $query->andWhere('b.Categories IN(:cats)')
                ->setParameter(':cats', array_values($filtersCat));
        }
            //getSingleScalarResult pour obtenir un résultat en chaine caractere et non en tableau
        return $query->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return Bivouac[] Returns an array of Bivouac objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bivouac
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
