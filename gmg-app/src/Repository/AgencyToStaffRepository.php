<?php

namespace App\Repository;

use App\Entity\AgencyToStaff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgencyToStaff|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgencyToStaff|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgencyToStaff[]    findAll()
 * @method AgencyToStaff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgencyToStaffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgencyToStaff::class);
    }

    // /**
    //  * @return AgencyToStaff[] Returns an array of AgencyToStaff objects
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
    public function findOneBySomeField($value): ?AgencyToStaff
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
