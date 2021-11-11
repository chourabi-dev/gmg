<?php

namespace App\Repository;

use App\Entity\PrivateNotes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrivateNotes|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivateNotes|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivateNotes[]    findAll()
 * @method PrivateNotes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivateNotesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivateNotes::class);
    }

    // /**
    //  * @return PrivateNotes[] Returns an array of PrivateNotes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrivateNotes
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
