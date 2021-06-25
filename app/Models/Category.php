<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\JobPosition;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }
}
