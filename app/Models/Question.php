<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use App\Models\Answer;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'exam_id',
        'link','type'
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function MyGroup(){
        return $this->belongsTo(group_question::class,'id','question_id');
    }
    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function lang($lang){
        return $this->hasMany(lang::class)->where('lang',$lang);
    }
}
