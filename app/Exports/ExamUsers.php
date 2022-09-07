<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;

class ExamUsers implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $id;
    public $campaign=0;
    public $uid=0;
    public function collection()
    {
        $exam = Exam::find($this->id);
        $where=[];
        if($this->campaign)
        $where[]=['campaign','=',$this->campaign];
        if($this->uid)
        $where[]=['users.id','>',$this->uid];
        return $exam->users()->where($where)->distinct()->get();
        
    }
}
