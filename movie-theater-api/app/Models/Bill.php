<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'bill_id';

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function billDetail(){
        return $this->belongsToMany(BillDetail::class);
    }

    public function billFood(){
        return $this->hasMany(BillFood::class);
    }
}
