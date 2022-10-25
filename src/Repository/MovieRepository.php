<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function save(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(string $term): array
    {
        $stmt = $this->createQueryBuilder('m');

        $stmt->leftJoin('m.director', 'd');
        $stmt->leftJoin('m.actors', 'a');

        $stmt->where(
            $stmt->expr()->orX(
                $stmt->expr()->like('m.title', ':term'),
                $stmt->expr()->like('m.description', ':term'),
                $stmt->expr()->like('a.firstname', ':term'),
                $stmt->expr()->like('a.lastname', ':term'),
                $stmt->expr()->like('d.firstname', ':term'),
                $stmt->expr()->like('d.lastname', ':term'),
            )
        );

//        $stmt->where('m.title LIKE :term');
//        $stmt->orWhere('m.description LIKE :term');
//        $stmt->orWhere('CONCAT(d.firstname, \' \', d.lastname) LIKE :term');
//        $stmt->orWhere('a.firstname LIKE :term');
//        $stmt->orWhere('a.lastname LIKE :term');

        $stmt->setParameter('term', '%' . $term . '%');

        $stmt->orderBy('m.title', 'ASC');
        return $stmt->getQuery()->getResult();
    }
}
