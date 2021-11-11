<?php

namespace App\Repository;

use App\Entity\CompanyDocuments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyDocuments|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyDocuments|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyDocuments[]    findAll()
 * @method CompanyDocuments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyDocumentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyDocuments::class);
    }

    // /**
    //  * @return CompanyDocuments[] Returns an array of CompanyDocuments objects
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
    public function findOneBySomeField($value): ?CompanyDocuments
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
