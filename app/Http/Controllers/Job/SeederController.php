<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\AddressSeeder;
use App\Models\EducationSeeder;
use App\Models\JobSeeder;
use Illuminate\Http\Request;

class SeederController extends Controller
{
    public function index()
    {
        $addresses = AddressSeeder::get();
        $education = EducationSeeder::get();
        $jobs = JobSeeder::get()->pluck('name');
        
        return view('job.create', compact('jobs', 'addresses', 'education'));
    }
}
