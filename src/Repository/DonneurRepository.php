<?php

namespace App\Repository;

use App\Entity\Donneur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Donneur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Donneur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Donneur[]    findAll()
 * @method Donneur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonneurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Donneur::class);
    }

    // /**
    //  * @return Donneur[] Returns an array of Donneur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Donneur
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
