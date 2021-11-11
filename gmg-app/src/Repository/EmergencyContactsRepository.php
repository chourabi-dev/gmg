<?php

namespace App\Repository;

use App\Entity\EmergencyContacts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmergencyContacts|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmergencyContacts|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmergencyContacts[]    findAll()
 * @method EmergencyContacts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmergencyContactsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmergencyContacts::class);
    }

    // /**
    //  * @return EmergencyContacts[] Returns an array of EmergencyContacts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EmergencyContacts
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
