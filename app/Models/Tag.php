<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function exams(){
        return $this->belongsToMany(Exam::class);
    }
}
