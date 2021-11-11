<?php

namespace App\Repository;

use App\Entity\CompanyAccounts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyAccounts|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyAccounts|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyAccounts[]    findAll()
 * @method CompanyAccounts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyAccountsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyAccounts::class);
    }

    // /**
    //  * @return CompanyAccounts[] Returns an array of CompanyAccounts objects
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
    public function findOneBySomeField($value): ?CompanyAccounts
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
