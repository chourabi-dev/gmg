<?php

namespace App\Repository;

use App\Entity\ContactsLanguages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContactsLanguages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactsLanguages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactsLanguages[]    findAll()
 * @method ContactsLanguages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactsLanguagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactsLanguages::class);
    }

    // /**
    //  * @return ContactsLanguages[] Returns an array of ContactsLanguages objects
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
    public function findOneBySomeField($value): ?ContactsLanguages
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
