<?php

namespace App\Repository\Base;

use App\Entity\Base\NasaAPODPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NasaAPODPost>
 *
 * @method NasaAPODPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method NasaAPODPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method NasaAPODPost[]    findAll()
 * @method NasaAPODPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NasaAPODPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NasaAPODPost::class);
    }

    public function findEarliestDateEntity(): ?NasaAPODPost
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.date', 'ASC') // Replace 'dateColumn' with the actual column name
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function addToDB($data): void
    {
        $post = new NasaAPODPost();
        $post->setTitle($data["title"]);
        $post->setExplanation($data["explanation"]);
        if (isset($data["copyright"])) {
            $post->setCopyright($data["copyright"]);
        }
        $post->setDate($data["date"]);
        $post->setUrl($data["url"]);
        $post->setColor(1);

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    //    /**
    //     * @return NasaAPODPost[] Returns an array of NasaAPODPost objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('n.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?NasaAPODPost
    //    {
    //        return $this->createQueryBuilder('n')
    //            ->andWhere('n.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
