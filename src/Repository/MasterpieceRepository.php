<?php

namespace App\Repository;

use App\Entity\Masterpiece;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class MasterpieceRepository.
 *
 * @extends ServiceEntityRepository<Masterpiece>
 *
 * @method Masterpiece|null find($id, $lockMode = null, $lockVersion = null)
 * @method Masterpiece|null findOneBy(array $criteria, array $orderBy = null)
 * @method Masterpiece[]    findAll()
 * @method Masterpiece[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasterpieceRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Masterpiece::class);
    }

    /**
     * Query all records.
     *
     * @param array<string, object> $filters Filters
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial masterpiece.{id, createdAt, updatedAt, title, author, description}',
                'partial category.{id, title}'
            )
            ->join('masterpiece.category', 'category')
            ->orderBy('masterpiece.updatedAt', 'DESC');

        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder          $queryBuilder Query builder
     * @param array<string, object> $filters      Filters array
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        return $queryBuilder;
    }

    /**
     * Count masterpieces by category.
     *
     * @param Category $category Category
     *
     * @return int Number of masterpieces in category
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('masterpiece.id'))
            ->where('masterpiece.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('masterpiece');
    }

    /**
     * Save entity.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     */
    public function save(Masterpiece $masterpiece): void
    {
        $this->_em->persist($masterpiece);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     */
    public function delete(Masterpiece $masterpiece): void
    {
        $this->_em->remove($masterpiece);
        $this->_em->flush();
    }

    //    /**
    //     * @return Masterpiece[] Returns an array of Masterpiece objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Masterpiece
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
