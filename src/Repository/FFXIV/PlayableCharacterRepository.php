<?php

namespace App\Repository\FFXIV;

use App\Entity\FFXIV\PlayableCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlayableCharacter>
 *
 * @method PlayableCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayableCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayableCharacter[]    findAll()
 * @method PlayableCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayableCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayableCharacter::class);
    }

    //    /**
    //     * @return PlayableCharacter[] Returns an array of PlayableCharacter objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PlayableCharacter
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
