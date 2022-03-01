<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
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
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findModel($nom)
    {
        $query = $this->createQueryBuilder(alias:'p')
                        ->where(predicates:'p.nom = :nom')
                        ->setParameters(['nom'=>$nom]
                        )
                        ->getQuery();
        return $query->getResult();
    }

    public function findGroup($id)
    {
        $query = $this->createQueryBuilder(alias:'p')
                        ->where(predicates:'p.souscategorie = :id')
                        ->setParameters(['id'=>$id]
                        )
                        ->groupBy('p.nom') 
                        ->getQuery();
        return $query->getResult();
    }

    public function findByTheme($id)
    {
        $query = $this->createQueryBuilder(alias:'p')
                        ->where(predicates:'p.theme = :id')
                        ->setParameters(['id'=>$id]
                        )
                        // ->groupBy('p.souscategorie')
                        ->getQuery();
        return $query->getResult();
    }

}
