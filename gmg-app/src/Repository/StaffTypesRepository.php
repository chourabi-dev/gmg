<?php

namespace App\Repository;

use App\Entity\StaffTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StaffTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method StaffTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method StaffTypes[]    findAll()
 * @method StaffTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StaffTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StaffTypes::class);
    }

    // /**
    //  * @return StaffTypes[] Returns an array of StaffTypes objects
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
    public function findOneBySomeField($value): ?StaffTypes
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
