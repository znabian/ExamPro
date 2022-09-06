<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group_question extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'question_id',
    ];
    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function group(){
        return $this->belongsTo(group::class);
    }
}
