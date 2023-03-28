<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormularConditation extends Model
{
    use HasFactory;
    public function formul()
    {
       return $this->belongsTo(exam_formular::class,'formular_id','id');
    }
    
    public function exam()
    {
       return $this->belongsTo(Exam::class);
    }
    public function lang($lang){
        return $this->hasMany(lang::class,'conditation_id','id')->where('lang',$lang);
    }
}
