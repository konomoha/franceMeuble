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

    //Méthode retournant toutes les informations de tous les produits ayant un nom précis, elle prend pour argument le nom du produit. Cela permettra d'avoir accès sur le template détail produit aux informations des variantes d'un même produit, notamment les couleurs
    public function findModel($nom)
    {
        $query = $this->createQueryBuilder(alias:'p')
                        ->where(predicates:'p.nom = :nom')
                        ->setParameters(['nom'=>$nom]
                        )
                        ->getQuery();
        return $query->getResult();
    }

    //findGroup() est une méthode retournant tous les produit ayant un id de sous-catégorie précis. Etant donné que plusieurs produit peuvent avoir le même nom mais une couleur différente, cette méthode regroupe les noms afin d'éviter les doublons. On s'en servira pour afficher de manière globale la liste de tous les produits pour telle ou telle catégorie.
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

    //findByTheme() permet de retrouver un produit ayant un id de theme précis. 
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
