<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'questions',
        'result','default',
        'status',
        'parent',
        'exam_id',
        'formul'
    ];
    public function MYparent()
    {
        return $this->belongsTo(group::class,'parent','id');
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function questions()
    {
        return $this->hasMany(group_question::class);
    }
}
