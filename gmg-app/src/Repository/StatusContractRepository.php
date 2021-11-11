<?php

namespace App\Repository;

use App\Entity\StatusContract;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatusContract|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusContract|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusContract[]    findAll()
 * @method StatusContract[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusContractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusContract::class);
    }

    // /**
    //  * @return StatusContract[] Returns an array of StatusContract objects
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
    public function findOneBySomeField($value): ?StatusContract
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
