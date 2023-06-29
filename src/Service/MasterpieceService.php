<?php
/**
 * Masterpiece service.
 */

namespace App\Service;

use App\Entity\Masterpiece;
use App\Repository\MasterpieceRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class MasterpieceService.
 */
class MasterpieceService implements MasterpieceServiceInterface
{
    /**
     * Masterpiece repository.
     */
    private MasterpieceRepository $masterpieceRepository;

    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService       Category service
     * @param MasterpieceRepository    $masterpieceRepository Masterpiece repository
     * @param PaginatorInterface       $paginator             Paginator
     */
    public function __construct(
        MasterpieceRepository $masterpieceRepository,
        PaginatorInterface $paginator,
        CategoryServiceInterface $categoryService
    ) {
        $this->masterpieceRepository = $masterpieceRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->masterpieceRepository->queryAll($filters),
            $page,
            MasterpieceRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }

    /**
     * Save entity.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     */
    public function save(Masterpiece $masterpiece): void
    {
        $this->masterpieceRepository->save($masterpiece);
    }

    /**
     * Delete entity.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     */
    public function delete(Masterpiece $masterpiece): void
    {
        $this->masterpieceRepository->delete($masterpiece);
    }
}
