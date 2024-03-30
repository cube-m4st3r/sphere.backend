<?php

namespace App\Repository\FFXIV;

use App\Entity\FFXIV\CGOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CGOrder>
 *
 * @method CGOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method CGOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method CGOrder[]    findAll()
 * @method CGOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CGOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CGOrder::class);
    }

//    /**
//     * @return CGOrder[] Returns an array of CGOrder objects
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

//    public function findOneBySomeField($value): ?CGOrder
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
