<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
class Conclusion extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'low',
        'high',
        'exam_id'
    ];

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
