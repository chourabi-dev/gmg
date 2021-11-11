<?php

namespace App\Repository;

use App\Entity\SubSkills;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubSkills|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubSkills|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubSkills[]    findAll()
 * @method SubSkills[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubSkillsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubSkills::class);
    }

    // /**
    //  * @return SubSkills[] Returns an array of SubSkills objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubSkills
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
