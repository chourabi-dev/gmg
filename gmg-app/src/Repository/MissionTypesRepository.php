<?php

namespace App\Repository;

use App\Entity\MissionTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MissionTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method MissionTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method MissionTypes[]    findAll()
 * @method MissionTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MissionTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MissionTypes::class);
    }

    // /**
    //  * @return MissionTypes[] Returns an array of MissionTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MissionTypes
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
