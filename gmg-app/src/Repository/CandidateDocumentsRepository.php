<?php

namespace App\Repository;

use App\Entity\CandidateDocuments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CandidateDocuments|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidateDocuments|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidateDocuments[]    findAll()
 * @method CandidateDocuments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateDocumentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidateDocuments::class);
    }

    // /**
    //  * @return CandidateDocuments[] Returns an array of CandidateDocuments objects
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
    public function findOneBySomeField($value): ?CandidateDocuments
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
