<?php

namespace App\Repository;

use App\Entity\SSimpleUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SSimpleUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SSimpleUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SSimpleUser[]    findAll()
 * @method SSimpleUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SSimpleUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SSimpleUser::class);
    }

    // /**
    //  * @return SSimpleUser[] Returns an array of SSimpleUser objects
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
    public function findOneBySomeField($value): ?SSimpleUser
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
