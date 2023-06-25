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
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param MasterpieceRepository     $masterpieceRepository Masterpiece repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(MasterpieceRepository $masterpieceRepository, PaginatorInterface $paginator)
    {
        $this->masterpieceRepository = $masterpieceRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->masterpieceRepository->queryAll(),
            $page,
            MasterpieceRepository::PAGINATOR_ITEMS_PER_PAGE
        );
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
