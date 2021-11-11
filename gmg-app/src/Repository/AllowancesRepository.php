<?php

namespace App\Repository;

use App\Entity\Allowances;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Allowances|null find($id, $lockMode = null, $lockVersion = null)
 * @method Allowances|null findOneBy(array $criteria, array $orderBy = null)
 * @method Allowances[]    findAll()
 * @method Allowances[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllowancesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Allowances::class);
    }

    // /**
    //  * @return Allowances[] Returns an array of Allowances objects
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
    public function findOneBySomeField($value): ?Allowances
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
