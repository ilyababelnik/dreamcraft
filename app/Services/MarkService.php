<?php

namespace App\Services;

use App\Http\Requests\Mark as Request;
use App\Repositories\Interfaces\MarkRepositoryInterface;

class MarkService
{
    public function __construct(protected MarkRepositoryInterface $markRepository)
    {
    }

    public function existMark(int $categoryId)
    {
        return $this->markRepository->existMark($categoryId);
    }

    public function createMark(Request\MarkCreateRequest $data)
    {
        return $this->markRepository->createMark($data);
    }

    public function updateMark(Request\MarkUpdateRequest $data, int $id)
    {
        return $this->markRepository->updateMark($data, $id);
    }

    public function deleteMark(int $id)
    {
        return $this->markRepository->deleteMark($id);
    }
}
