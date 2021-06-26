<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Entity;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'dni',
        'birthdate',
        'address',
        'picture',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function entity(){
        return $this->belongsTo(Entity::class);
    }

}
