<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'description',
        'image',
    ];
    public function payments(){
        return $this->hasMany(Payment::class);
    }
}
