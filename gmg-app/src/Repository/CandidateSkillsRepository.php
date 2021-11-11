<?php

namespace App\Repository;

use App\Entity\CandidateSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CandidateSkills|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidateSkills|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidateSkills[]    findAll()
 * @method CandidateSkills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidateSkills::class);
    }

    // /**
    //  * @return CandidateSkills[] Returns an array of CandidateSkills objects
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
    public function findOneBySomeField($value): ?CandidateSkills
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
