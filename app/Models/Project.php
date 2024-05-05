<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'link_power_bi',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class,'user_project');
    }
}
