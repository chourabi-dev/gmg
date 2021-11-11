<?php

namespace App\Repository;

use App\Entity\CompanyLocations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyLocations|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyLocations|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyLocations[]    findAll()
 * @method CompanyLocations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyLocationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyLocations::class);
    }

    // /**
    //  * @return CompanyLocations[] Returns an array of CompanyLocations objects
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
    public function findOneBySomeField($value): ?CompanyLocations
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
