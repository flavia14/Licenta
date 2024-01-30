<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Request\CommentRequestDto;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Repository\CommentRepository;
use App\Transformer\CommentTransformer;

class CommentService
{
    private CommentRepository $commentRepository;
    private CommentTransformer $commentTransformer;

    public function __construct(
        CommentRepository  $commentRepository,
        CommentTransformer $commentTransformer
    )
    {
        $this->commentRepository = $commentRepository;
        $this->commentTransformer = $commentTransformer;
    }

    public function getListOfComments(int $microPostId): array
    {
        $comments = $this->commentRepository->findByPostId($microPostId);

        return $this->commentTransformer->convertCommentsToDto($comments);
    }

    public function addComment(MicroPost $microPostId, CommentRequestDto $commentRequestDto): void
    {
        $comment = new Comment();

        $comment->setPost($microPostId)
            ->setText($commentRequestDto->text);

        $this->commentRepository->save($comment, true);
    }
}
