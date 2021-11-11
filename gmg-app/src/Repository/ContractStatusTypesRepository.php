<?php

namespace App\Repository;

use App\Entity\ContractStatusTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractStatusTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractStatusTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractStatusTypes[]    findAll()
 * @method ContractStatusTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractStatusTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractStatusTypes::class);
    }

    // /**
    //  * @return ContractStatusTypes[] Returns an array of ContractStatusTypes objects
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
    public function findOneBySomeField($value): ?ContractStatusTypes
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
