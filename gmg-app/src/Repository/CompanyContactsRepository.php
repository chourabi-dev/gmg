<?php

namespace App\Repository;

use App\Entity\CompanyContacts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyContacts|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyContacts|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyContacts[]    findAll()
 * @method CompanyContacts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyContactsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyContacts::class);
    }

    // /**
    //  * @return CompanyContacts[] Returns an array of CompanyContacts objects
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
    public function findOneBySomeField($value): ?CompanyContacts
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
