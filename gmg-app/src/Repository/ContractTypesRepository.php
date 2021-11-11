<?php

namespace App\Repository;

use App\Entity\ContractTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContractTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractTypes[]    findAll()
 * @method ContractTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContractTypes::class);
    }

    // /**
    //  * @return ContractTypes[] Returns an array of ContractTypes objects
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
    public function findOneBySomeField($value): ?ContractTypes
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
