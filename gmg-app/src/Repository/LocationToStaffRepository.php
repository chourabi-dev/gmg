<?php

namespace App\Repository;

use App\Entity\LocationToStaff;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LocationToStaff|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationToStaff|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationToStaff[]    findAll()
 * @method LocationToStaff[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationToStaffRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationToStaff::class);
    }

    // /**
    //  * @return LocationToStaff[] Returns an array of LocationToStaff objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LocationToStaff
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
