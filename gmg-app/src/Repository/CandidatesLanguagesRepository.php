<?php

namespace App\Repository;

use App\Entity\CandidatesLanguages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CandidatesLanguages|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidatesLanguages|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidatesLanguages[]    findAll()
 * @method CandidatesLanguages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatesLanguagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidatesLanguages::class);
    }

    // /**
    //  * @return CandidatesLanguages[] Returns an array of CandidatesLanguages objects
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
    public function findOneBySomeField($value): ?CandidatesLanguages
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
