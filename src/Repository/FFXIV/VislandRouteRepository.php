<?php

namespace App\Repository\FFXIV;

use App\Entity\FFXIV\VislandRoute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VislandRoute>
 *
 * @method VislandRoute|null find($id, $lockMode = null, $lockVersion = null)
 * @method VislandRoute|null findOneBy(array $criteria, array $orderBy = null)
 * @method VislandRoute[]    findAll()
 * @method VislandRoute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VislandRouteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VislandRoute::class);
    }

    //    /**
    //     * @return VislandRoute[] Returns an array of VislandRoute objects
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

    //    public function findOneBySomeField($value): ?VislandRoute
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
