<?php

namespace App\Services;

use App\Exceptions\InvalidNumbericException;
use App\Exceptions\ObjectEmptyException;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Exceptions;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryService
{

    protected $categoryRepositoryInterface;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }

    public function getAll($size, $isEnabled)
    {
        if (!is_numeric($size) || $size < 0) {
            throw new InvalidNumbericException("size phải là một số nguyên lớn hơn 0");
        }

        if (empty($isEnabled)) {
            return $this->categoryRepositoryInterface->getAll($size);
        }
        return $this->categoryRepositoryInterface->getAllIsEnabled($size, $isEnabled);
    }

    public function getById($id)
    {
        $category =  $this->categoryRepositoryInterface->getById($id);

        if (empty($category)) {
            throw new ObjectEmptyException('Không có thể loại nào có id là ' . $id);
        }
        return $category;
    }

    public function create(CategoryRequest $request)
    {
        return $this->categoryRepositoryInterface->create($request);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::find($id);

        if (empty($category)) {
            throw new ObjectEmptyException('Không có thể loại nào có id là ' . $id);
        }

        return $this->categoryRepositoryInterface->update($request, $id);
    }

    public function isEnabled($id)
    {

        $category = Category::find($id);

        if (empty($category)) {
            throw new ObjectEmptyException('Không có thể loại nào có id là ' . $id);
        }

        $this->categoryRepositoryInterface->isEnabled($category);

        return $category;
    }

    public function getListName()
    {
        $categoryNames = $this->categoryRepositoryInterface->getListName();

        if(count($categoryNames) <= 0){
            throw new ObjectEmptyException('Danh sach ten the loai trong');
        }
        return $categoryNames;
    }

    public function getByName($categoryName)
    {
        $category = $this->categoryRepositoryInterface->getByName($categoryName);

        if(empty($category)){
            throw new ObjectEmptyException('Khong co phim nao thoa man');
        }
        return $category;
    }
}
