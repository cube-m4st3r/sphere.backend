<?php

namespace App\Repository\Anime;

use App\Entity\Anime\AnimeThemes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimeThemes>
 *
 * @method AnimeThemes|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimeThemes|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimeThemes[]    findAll()
 * @method AnimeThemes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeThemesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimeThemes::class);
    }

    //    /**
    //     * @return AnimeThemes[] Returns an array of AnimeThemes objects
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

    //    public function findOneBySomeField($value): ?AnimeThemes
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
