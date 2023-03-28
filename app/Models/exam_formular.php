<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exam_formular extends Model
{
    use HasFactory;
    public function exam()
    {
       return $this->belongsTo(Exam::class);
    }
    public function conditations()
    {
        return $this->hasMany(FormularConditation::class,'formular_id','id');
    }
    public function lang($lang){
        return $this->hasMany(lang::class,'formular_id','id')->where('lang',$lang);
    }
}
