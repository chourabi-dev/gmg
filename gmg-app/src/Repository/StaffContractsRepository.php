<?php

namespace App\Repository;

use App\Entity\StaffContracts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StaffContracts|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaffContracts|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaffContracts[]    findAll()
 * @method StaffContracts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffContractsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StaffContracts::class);
    }

    // /**
    //  * @return StaffContracts[] Returns an array of StaffContracts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StaffContracts
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
