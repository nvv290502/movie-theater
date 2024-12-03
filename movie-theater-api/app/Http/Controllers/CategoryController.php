<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $size = request()->input("size", 5);
        $isEnabled = request()->get('isEnabled');
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách thể loại',
            'data' => $this->categoryService->getAll($size, $isEnabled)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category =  $this->categoryService->create($request);

        return response()->json([
            'status' => 201,
            'message' => 'Thêm mới category thành công',
            'data' => $category
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->categoryService->getById($id);

        return response()->json([
            'status' => 200,
            'message' => 'Thể loại có id là ' . $id,
            'data' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryService->update($request, $id);

        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat the loai co id la ' . $id . ' thanh cong',
            'data' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = $this->categoryService->isEnabled($id);
        
        return response()->json([
            'status' => 200,
            'message' => 'Cap nhat trang thai the loai co id la ' . $id . ' thanh cong',
            'data' => $category
        ]);
    }

    public function getListName()
    {
        $categoryNames = $this->categoryService->getListName();

        return response()->json([
            'status' => 200,
            'message' => 'Danh sach ten the loai',
            'data' => $categoryNames
        ]);
    }

    public function getByName($name)
    {
        $category = $this->categoryService->getByName($name);

        return response()->json([
            'status' => 200,
            'message' => 'Tim kiem the loai thanh cong',
            'data' => $category
        ]);
    }
}
