<?php

namespace App\Repository;

use App\Entity\SimpleUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SimpleUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method SimpleUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method SimpleUser[]    findAll()
 * @method SimpleUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SimpleUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SimpleUser::class);
    }

    // /**
    //  * @return SimpleUser[] Returns an array of SimpleUser objects
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
    public function findOneBySomeField($value): ?SimpleUser
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function afffichertoutdemandeur(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT de.gpe,de.message FROM simple_user su ,demandeur de 
        WHERE  su.id=de.userdemandeur_id  
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function afffichertoutdonneur(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT de.gpe,de.message  FROM simple_user su ,donneur de 
        WHERE  su.id=de.usedonneur_id  
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function ttlesdemaneur(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT de.count(*) FROM demandeur de 
       
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function ttlesdonneur(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT COUNT(*) FROM donneur 
       
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function ttlesdemandeur(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT COUNT(*) FROM demandeur 
       
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
}
