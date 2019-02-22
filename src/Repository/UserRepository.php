<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\DBAL\Statement;
/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function iddesimpleuser($iduser): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT su.* FROM simple_user su,user u,utilisateur uti
        WHERE u.id = :iduser AND u.id=uti.userutilisateur_id AND su.id=uti.simutilisateur_id
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['iduser' => $iduser]);
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function nomprenomutilisateur($iduser): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT uti.id FROM user u,utilisateur uti
        WHERE u.id = :iduser AND u.id=uti.userutilisateur_id 
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['iduser' => $iduser]);
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function findalladmin(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT u.*,uti.* FROM user u, utilisateur uti 
        WHERE u.id = uti.userutilisateur_id 
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function compteuser(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT COUNT(*) FROM simple_user  
        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
    public function getcoordonnesuser($user): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM user u,utilisateur uti,simple_user su 
        where   
        u.id = uti.userutilisateur_id and u.id=:user  AND su.id=uti.simutilisateur_id
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user'=> $user]);
        return $stmt->fetchAll();
        // returns an array of arrays (i.e. a raw data set)

    }
}
