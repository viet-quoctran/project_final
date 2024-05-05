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
        'quality_dashboard',
    ];
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    public function users(){
        return $this->belongsToMany(User::class);
    }
    
}
