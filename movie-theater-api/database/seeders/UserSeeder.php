<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username'=>'test',
            'email'=>'test@gmail.com',
            'full_name'=>'nguyen van vy',
            'phone'=>'04358508011',
            'is_enabled'=>true,
            'is_confirm'=>true,
            'password'=>Hash::make('123456'),
            'role_id'=>1
        ]);
    }
}
