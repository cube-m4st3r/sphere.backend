<?php

namespace App\Repository\Anime;

use App\Entity\Anime\AnimeShow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimeShow>
 *
 * @method AnimeShow|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimeShow|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimeShow[]    findAll()
 * @method AnimeShow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeShowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimeShow::class);
    }

    //    /**
    //     * @return AnimeShow[] Returns an array of AnimeShow objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AnimeShow
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
