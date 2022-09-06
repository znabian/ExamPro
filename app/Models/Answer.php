<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value',
        'question_id',
        'char_value',
        'is_char',
        'link','type'
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
