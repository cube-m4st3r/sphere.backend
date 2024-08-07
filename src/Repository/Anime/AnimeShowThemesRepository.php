<?php

namespace App\Repository\Anime;

use App\Entity\Anime\AnimeShowThemes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimeShowThemes>
 *
 * @method AnimeShowThemes|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimeShowThemes|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimeShowThemes[]    findAll()
 * @method AnimeShowThemes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeShowThemesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimeShowThemes::class);
    }

    //    /**
    //     * @return AnimeShowThemes[] Returns an array of AnimeShowThemes objects
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

    //    public function findOneBySomeField($value): ?AnimeShowThemes
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
