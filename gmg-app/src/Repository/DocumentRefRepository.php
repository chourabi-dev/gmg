<?php

namespace App\Repository;

use App\Entity\DocumentRef;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocumentRef|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentRef|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentRef[]    findAll()
 * @method DocumentRef[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentRefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentRef::class);
    }

    // /**
    //  * @return DocumentRef[] Returns an array of DocumentRef objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DocumentRef
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
