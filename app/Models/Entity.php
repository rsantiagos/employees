<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identifier'
    ];

    public function jobPosition(){
        return $this->hasMany(Entity::class);
    }

    public function employee(){
        return $this->hasMany(Entity::class);
    }
}
