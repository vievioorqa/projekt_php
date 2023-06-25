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
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;
}
