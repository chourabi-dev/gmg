<?php

namespace App\Repository;

use App\Entity\Currencies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Currencies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Currencies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Currencies[]    findAll()
 * @method Currencies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CurrenciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currencies::class);
    }

    // /**
    //  * @return Currencies[] Returns an array of Currencies objects
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
    public function findOneBySomeField($value): ?Currencies
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
