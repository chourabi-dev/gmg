<?php

namespace App\Repository;

use App\Entity\AllowanceTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AllowanceTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method AllowanceTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method AllowanceTypes[]    findAll()
 * @method AllowanceTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AllowanceTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AllowanceTypes::class);
    }

    // /**
    //  * @return AllowanceTypes[] Returns an array of AllowanceTypes objects
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
    public function findOneBySomeField($value): ?AllowanceTypes
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
