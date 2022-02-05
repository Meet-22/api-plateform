<?php

namespace App\Repository;

use App\Entity\Libarary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Libarary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Libarary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Libarary[]    findAll()
 * @method Libarary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibararyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libarary::class);
    }

    // /**
    //  * @return Libarary[] Returns an array of Libarary objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Libarary
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
