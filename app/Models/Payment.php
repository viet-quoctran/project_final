<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'amount',
    ];
    public function users(){
        return $this->belongsToMany(User::class);
    }
}
