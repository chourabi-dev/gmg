<?php

namespace App\Repository;

use App\Entity\CandidatesPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CandidatesPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidatesPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidatesPayment[]    findAll()
 * @method CandidatesPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatesPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidatesPayment::class);
    }

    // /**
    //  * @return CandidatesPayment[] Returns an array of CandidatesPayment objects
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
    public function findOneBySomeField($value): ?CandidatesPayment
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
