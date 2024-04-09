<?php

namespace App\Repository;

use App\Entity\NotifRelais;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotifRelais>
 *
 * @method NotifRelais|null find($id, $lockMode = null, $lockVersion = null)
 * @method NotifRelais|null findOneBy(array $criteria, array $orderBy = null)
 * @method NotifRelais[]    findAll()
 * @method NotifRelais[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotifRelaisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotifRelais::class);
    }

//    /**
//     * @return NotifRelais[] Returns an array of NotifRelais objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NotifRelais
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
