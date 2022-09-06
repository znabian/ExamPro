<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'alt',
        'fileable_id',
        'fileable_type'
    ];
    public function fileable(){
        return $this->morphTo();
    }
}
