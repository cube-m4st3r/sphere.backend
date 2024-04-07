<?php

namespace App\Repository\FFXIV;

use App\Entity\FFXIV\VislandRouteItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VislandRouteItem>
 *
 * @method VislandRouteItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method VislandRouteItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method VislandRouteItem[]    findAll()
 * @method VislandRouteItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VislandRouteItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VislandRouteItem::class);
    }

//    /**
//     * @return VislandRouteItem[] Returns an array of VislandRouteItem objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VislandRouteItem
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
