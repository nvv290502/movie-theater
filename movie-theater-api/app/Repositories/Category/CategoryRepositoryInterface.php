<?php

namespace App\Repositories\Category;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\User;

interface CategoryRepositoryInterface
{
    public function getAll($size);
    public function getAllIsEnabled($size, $isEnabled);
    public function getById($id);
    public function create(CategoryRequest $request);
    public function update(CategoryRequest $request, $id);
    public function isEnabled(Category $category);
    public function getListName();
    public function getByName($categoryName);
}
