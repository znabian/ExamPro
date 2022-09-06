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
    public function collection()
    {
        $exam = Exam::find($this->id);
        return $exam->users()->distinct()->get();
    }
}
