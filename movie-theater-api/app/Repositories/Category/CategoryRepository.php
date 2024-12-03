<?php

namespace App\Repositories\Category;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll($size)
    {
        return Category::query()->paginate($size);
    }

    public function getAllIsEnabled($size, $isEnabled)
    {
        return Category::where('is_enabled', $isEnabled)->paginate($size);
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

    public function update(CategoryRequest $request, $id)
    {
        return Category::updateOrCreate(
            ['category_id' => $id],
            [
                'category_name' => $request->name,
                'descripton' => $request->description
            ]
        );
    }

    public function isEnabled(Category $category)
    {
        return $category->update([
            'is_enabled' => !$category->is_enabled,
        ]);
    }

    public function getListName()
    {
        return DB::table('categories as c')
            ->pluck('category_name');
    }

    public function getByName($categoryName)
    {
        return Category::where('category_name', $categoryName)
            ->first();
    }
}
