<?php

namespace App\Repository;

use App\Entity\Assortiment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Assortiment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Assortiment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Assortiment[]    findAll()
 * @method Assortiment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssortimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assortiment::class);
    }

    // /**
    //  * @return Assortiment[] Returns an array of Assortiment objects
    //  */
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
    public function findOneBySomeField($value): ?Assortiment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
