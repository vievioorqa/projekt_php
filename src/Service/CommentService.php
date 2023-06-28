<?php
/**
 * Comment service.
 */

namespace App\Service;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\MasterpieceRepository;


/**
 * Class CommentService.
 */
class CommentService implements CommentServiceInterface
{
    /**
     * Masterpiece repository.
     */
    private MasterpieceRepository $masterpieceRepository;

    /**
     * Comment repository.
     */
    private CommentRepository $commentRepository;

    /**
     * Constructor.
     *
     * @param CommentRepository    $commentRepository    Comment repository
     * @param MasterpieceRepository $masterpieceRepository Masterpiece repository
     */
    public function __construct(
        CommentRepository $commentRepository,
        MasterpieceRepository $masterpieceRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->masterpieceRepository = $masterpieceRepository;
    }


    /**
     * Save entity.
     *
     * @param Comment $comment
     *Comment entity
     */
    public function save(Comment $comment): void
    {
        $this->commentRepository->save($comment);
    }

    /**
     * Delete entity.
     *
     * @param Comment $comment
     *Comment entity
     */
    public function delete(Comment $comment): void
    {
        $this->commentRepository->delete($comment);
    }

}
