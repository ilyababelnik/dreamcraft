<?php

namespace App\Services;

use App\Http\Requests\Comment as Request;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentService
{
    public function __construct(protected CommentRepositoryInterface $commentRepository)
    {
    }

    public function getRandomComments()
    {
        return $this->commentRepository->getRandomComments();
    }

    public function createComment(Request\CommentCreateRequest $data)
    {
        return $this->commentRepository->createComment($data);
    }

    public function updateComment(Request\CommentUpdateRequest $data, int $id)
    {
        return $this->commentRepository->updateComment($data, $id);
    }

    public function deleteComment(int $id)
    {
        return $this->commentRepository->deleteComment($id);
    }
}
