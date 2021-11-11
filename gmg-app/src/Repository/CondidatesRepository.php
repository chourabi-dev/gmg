<?php

namespace App\Repository;

use App\Entity\Condidates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Condidates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Condidates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Condidates[]    findAll()
 * @method Condidates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CondidatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Condidates::class);
    }

    // /**
    //  * @return Condidates[] Returns an array of Condidates objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Condidates
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
