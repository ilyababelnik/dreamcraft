<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Mark as Request;

interface MarkRepositoryInterface
{
    public function existMark(int $categoryId);

    public function createMark(Request\MarkCreateRequest $data);

    public function updateMark(Request\MarkUpdateRequest $data, int $markId);

    public function deleteMark(int $markId);
}
