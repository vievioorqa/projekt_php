<?php
/**
 * Masterpiece service interface.
 */

namespace App\Service;

use App\Entity\Masterpiece;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface MasterpieceServiceInterface.
 */
interface MasterpieceServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     */
    public function save(Masterpiece $masterpiece): void;

    /**
     * Delete entity.
     *
     * @param Masterpiece $masterpiece Masterpiece entity
     */
    public function delete(Masterpiece $masterpiece): void;
}
