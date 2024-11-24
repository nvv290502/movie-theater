<?php

namespace App\Repositories\Category;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll($size)
    {
        return Category::where('is_enabled', 1)->paginate($size);
    }

    public function getById($id)
    {
        return Category::where('is_enabled', 1)->find($id);
    }

    public function create(CategoryRequest $request)
    {
        return Category::create([
            'category_name' => $request->name,
            'description' => $request->description
        ]);
    }
}
