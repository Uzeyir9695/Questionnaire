<?php

namespace App\Http\Controllers\Job;

use App\Exports\CandidateExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export() 
    {
        return Excel::download(new CandidateExport, 'candidates.xlsx');
    }
}
