<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 200,
            'message' => 'Danh sach nguoi dung',
            'data' => $this->collection->transform(function($user){
                return [
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'address' => $user->address,
                    'is_enabled' => $user->is_enabled,
                    'member_ship_level' => $user->member_ship_level,
                    'role_id'=> $user->roles->role_id,
                    'role_name'=> $user->roles->role_name 
                ];
            }),
        ];
    }
}
