<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Comment as Request;

interface CommentRepositoryInterface
{
    public function getRandomComments();

    public function createComment(Request\CommentCreateRequest $data);

    public function updateComment(Request\CommentUpdateRequest $data, int $commentId);

    public function deleteComment(int $commentId);
}
