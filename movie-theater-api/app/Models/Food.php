<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    protected $primaryKey = 'food_id';

    public function billFood()
    {
        return $this->belongsTo(BillFood::class);
    }
}
