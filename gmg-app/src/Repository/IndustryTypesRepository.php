<?php

namespace App\Repository;

use App\Entity\IndustryTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IndustryTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method IndustryTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method IndustryTypes[]    findAll()
 * @method IndustryTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndustryTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IndustryTypes::class);
    }

    // /**
    //  * @return IndustryTypes[] Returns an array of IndustryTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IndustryTypes
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
