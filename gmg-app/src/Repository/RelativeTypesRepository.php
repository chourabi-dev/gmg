<?php

namespace App\Repository;

use App\Entity\RelativeTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RelativeTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method RelativeTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method RelativeTypes[]    findAll()
 * @method RelativeTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelativeTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RelativeTypes::class);
    }

    // /**
    //  * @return RelativeTypes[] Returns an array of RelativeTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RelativeTypes
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
