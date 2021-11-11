<?php

namespace App\Repository;

use App\Entity\PackTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PackTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PackTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PackTypes[]    findAll()
 * @method PackTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PackTypes::class);
    }

    // /**
    //  * @return PackTypes[] Returns an array of PackTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PackTypes
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
