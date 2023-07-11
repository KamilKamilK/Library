<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllBySearchForm($title, $publisher, $isPublished): array
    {
        $queryBuilder = $this->createQueryBuilder('b');

        if (!empty($title)) {
            $queryBuilder->andWhere('b.title LIKE :title')
                ->setParameter('title', '%'.$title.'%');
        }

        if (!empty($publisher)) {
            $queryBuilder->andWhere('b.publisher LIKE :publisher')
                ->setParameter('publisher', '%'.$publisher.'%');
        }

        if (!is_null($isPublished)) {
            $queryBuilder->andWhere('b.isPublished = :isPublished')
                ->setParameter('isPublished', $isPublished);
        }

        $queryBuilder->orderBy('b.id', 'ASC')
            ->setMaxResults(10);

        return $queryBuilder->getQuery()->getResult();
    }
}
