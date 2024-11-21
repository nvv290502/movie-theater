<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ImageService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        return $this->imageService = $imageService;
    }

    public function index()
    {
        return new UserCollection(User::paginate());
    }

    public function get($id)
    {

        $this->isNumeric($id);

        try {
            $user = User::findOrFail($id);
            return new UserResource($user);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => 404,
                'message' => 'Nguoi dung khong ton tai'
            ], 404);
        } catch (Exception $ex) {
            return response()->json([
                'status' => 500,
                'message' => 'Loi server'
            ], 500);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->isNumeric($id);

        try {
            $user = User::find($id);
            $imagePath = $this->imageService->imageUpload($request->file('avatar_url'));
            $data = $request->all();
            $data['avatar_url'] = $imagePath;
            $user->update($data);
            return response()->json([
                'status' => 202,
                'message' => 'Cap nhat thanh cong',
                'data' => $user,
            ], 202);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => 404,
                'message' => 'Nguoi dung khong ton tai'
            ], 404);
        }
    }

    public function isEnabled(Request $request, $id)
    {

        $this->isNumeric($id);

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'status' => 404,
                'message' => 'Nguoi dung khong ton tai'
            ], 404);
        }
        
        $user->update(['is_enabled' => (bool) $request['isEnabled']]);

        return response()->json([
            'status' => 202,
            'message' => 'Cap nhat enabled thanh cong',
        ], 202);
    }

    function isNumeric($id)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'status' => 400,
                'message' => 'Id khong hop le'
            ], 400);
        }
    }
}
