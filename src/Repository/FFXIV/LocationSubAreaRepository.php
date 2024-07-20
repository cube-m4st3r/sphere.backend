<?php

namespace App\Repository\FFXIV;

use App\Entity\FFXIV\LocationSubArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LocationSubArea>
 *
 * @method LocationSubArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationSubArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationSubArea[]    findAll()
 * @method LocationSubArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationSubAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationSubArea::class);
    }

    //    /**
    //     * @return LocationSubArea[] Returns an array of LocationSubArea objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LocationSubArea
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
