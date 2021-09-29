<?php

namespace App\Exports;

use App\Models\Candidate;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class CandidateExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
 
    public function headings(): array
        {
            //Put Here Header Name That you want in your excel sheet 
            return [
                'candidate_id',
                'user_id',
                'სახელი',
                'გვარი',
                'ემაილი',
                'სქესი',
                'დაბადების თარიღი',
                'შეიქმნა',
                'განახლდა',
                'candidate_id',
                'ქალაქი',
                'რაიონი',
                'ქუჩა',
                'ბინა',
                'განათლება',
                'პროფესია',
                'დასაქმების სფერო'
            ];
        }
    public function collection()
    {
      
        $candidates = Candidate::join('addresses', 'addresses.candidate_id', '=', 'candidates.id')
        ->join('education', 'education.candidate_id', 'candidates.id')
        ->join('jobs', 'jobs.candidate_id', 'candidates.id')
        ->select('candidates.*', 'addresses.city', 'addresses.district', 'addresses.street', 'addresses.apartment',
                  'education.education', 'education.profession', 'jobs.employment')->get();
        
        return $candidates;
    }
}
