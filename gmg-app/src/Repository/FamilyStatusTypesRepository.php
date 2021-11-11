<?php

namespace App\Repository;

use App\Entity\FamilyStatusTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FamilyStatusTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilyStatusTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilyStatusTypes[]    findAll()
 * @method FamilyStatusTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilyStatusTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FamilyStatusTypes::class);
    }

    // /**
    //  * @return FamilyStatusTypes[] Returns an array of FamilyStatusTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamilyStatusTypes
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
