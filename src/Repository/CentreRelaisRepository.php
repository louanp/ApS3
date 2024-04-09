<?php

namespace App\Repository;

use App\Entity\CentreRelais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CentreRelais>
 *
 * @method CentreRelais|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentreRelais|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentreRelais[]    findAll()
 * @method CentreRelais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreRelaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentreRelais::class);
    }

//    /**
//     * @return CentreRelais[] Returns an array of CentreRelais objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CentreRelais
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
