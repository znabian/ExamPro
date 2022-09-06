<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Conclusion;
use App\Models\Question;
use App\Models\Tag;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'englishName',
        'description',
        'level',
        'time',
        'ageRange',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function conclusions(){
        return $this->hasMany(Conclusion::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
    public function groups()
    {
        return $this->hasMany(group::class);
    }
    
    public function formuls()
    {
        return $this->hasMany(exam_formular::class);
    }
    
    public function conditation()
    {
        return $this->hasMany(FormularConditation::class);
    }
}
