<?php

namespace App\Repository;

use App\Entity\Retours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Retours>
 *
 * @method Retours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Retours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Retours[]    findAll()
 * @method Retours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RetoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Retours::class);
    }

//    /**
//     * @return Retours[] Returns an array of Retours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Retours
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
