<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillFood extends Model
{
    use HasFactory;

    protected $primaryKey = ['bill_id', 'food_id'];

    public function foods(){
        return $this->hasMany(Food::class);
    }

    public function bills(){
        return $this->belongsToMany(Bill::class);
    }

}
