<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'is_enabled' => $this->is_enabled,
            'member_ship_level' => $this->member_ship_level,
            'role_id'=> $this->roles->role_id,
            'role_name'=> $this->roles->role_name,
            'dob' => $this->date_of_birth,
            'avatar_url' => $this->avatar_url,
            'is_confirm' => $this->is_confirm,
            'created_at' => $this->created_at,
            'full_name' => $this->full_name
        ];
    }

    public function with($request){
        return [
            'status' => 200,
            'message' => 'Thong tin nguoi dung'
        ];
    }
}
