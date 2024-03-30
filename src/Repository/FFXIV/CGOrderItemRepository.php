<?php

namespace App\Repository\FFXIV;

use App\Entity\FFXIV\CGOrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CGOrderItem>
 *
 * @method CGOrderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CGOrderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CGOrderItem[]    findAll()
 * @method CGOrderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CGOrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CGOrderItem::class);
    }

    //    /**
    //     * @return CGOrderItem[] Returns an array of CGOrderItem objects
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

    //    public function findOneBySomeField($value): ?CGOrderItem
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
