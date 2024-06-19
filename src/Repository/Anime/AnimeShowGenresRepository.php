<?php

namespace App\Repository\Anime;

use App\Entity\Anime\AnimeShowGenres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnimeShowGenres>
 *
 * @method AnimeShowGenres|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimeShowGenres|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimeShowGenres[]    findAll()
 * @method AnimeShowGenres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeShowDatasetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimeShowGenres::class);
    }

//    /**
//     * @return AnimeShowGenres[] Returns an array of AnimeShowGenres objects
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

//    public function findOneBySomeField($value): ?AnimeShowGenres
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
