<?php

namespace App\Repository;

use App\Entity\StatusTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatusTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusTypes[]    findAll()
 * @method StatusTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusTypes::class);
    }

    // /**
    //  * @return StatusTypes[] Returns an array of StatusTypes objects
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
    public function findOneBySomeField($value): ?StatusTypes
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
