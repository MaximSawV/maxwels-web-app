<?php

namespace App\Repository;

use App\Entity\ProfileOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfileOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileOptions[]    findAll()
 * @method ProfileOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileOptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfileOptions::class);
    }

    // /**
    //  * @return ProfileOptions[] Returns an array of ProfileOptions objects
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
    public function findOneBySomeField($value): ?ProfileOptions
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
