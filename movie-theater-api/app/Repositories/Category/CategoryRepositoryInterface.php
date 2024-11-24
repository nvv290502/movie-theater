<?php

namespace App\Repositories\Category;

use App\Http\Requests\CategoryRequest;

interface CategoryRepositoryInterface
{
    public function getAll($size);
    public function getById($id);
    public function create(CategoryRequest $request);
}
