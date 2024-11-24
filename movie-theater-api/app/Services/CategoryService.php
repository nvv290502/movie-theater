<?php

namespace App\Services;

use App\Exceptions\InvalidNumbericException;
use App\Exceptions\ObjectEmptyException;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Exceptions;
use App\Http\Requests\CategoryRequest;

class CategoryService
{

    protected $categoryRepositoryInterface;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }

    public function getAll($size)
    {
        if (!is_numeric($size) || $size < 0) {
            throw new InvalidNumbericException("size phải là một số nguyên lớn hơn 0");
        }
        return $this->categoryRepositoryInterface->getAll($size);
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
}
