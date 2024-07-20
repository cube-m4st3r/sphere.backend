<?php

namespace App\Repository\FFXIV;

use App\Entity\FFXIV\LocationMainArea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LocationMainArea>
 *
 * @method LocationMainArea|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationMainArea|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationMainArea[]    findAll()
 * @method LocationMainArea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationMainAreaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LocationMainArea::class);
    }

    //    /**
    //     * @return LocationMainArea[] Returns an array of LocationMainArea objects
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

    //    public function findOneBySomeField($value): ?LocationMainArea
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
