<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Mail\JobMail;
use App\Models\Address;
use App\Models\AddressSeeder;
use App\Models\Candidate;
use App\Models\Education;
use App\Models\EducationSeeder;
use App\Models\Job;
use App\Models\JobSeeder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = AddressSeeder::get();
        $education = EducationSeeder::get();
        $jobs = JobSeeder::get();


        if(!empty($request->all())  ){
            $candidates = Candidate::join('addresses', 'candidates.id', 'addresses.candidate_id')
               ->join('education', 'candidates.id', 'education.candidate_id')
               ->join('jobs', 'candidates.id', 'jobs.candidate_id')
               ->select('candidates.*', 'addresses.*', 'education.*', 'jobs.employment')
                ->when(!empty($request->filter_sex), function ($query) use($request){
                    return $query->where('sex', $request->filter_sex);
                })
                ->when(!empty($request->filter_city and $request->filter_district), function ($query) use($request){

                    return $query->orWhere('district', $request->filter_district)
                        ->orWhere('city', $request->filter_city);
                })
                ->when(!empty($request->filter_edu), function ($query) use($request){

                    return $query->orWhere('education', $request->filter_edu);
                })
                ->when(!empty($request->filter_job), function ($query) use($request){

                    return $query->orWhere('employment', $request->filter_job);
                })
               ->paginate(10);

            return view('job.index', compact('candidates', 'addresses', 'education', 'jobs'));
        }
        else
        {
            $candidates = Candidate::join('addresses', 'addresses.candidate_id', 'candidates.id')
            ->join('education', 'education.candidate_id', 'candidates.id')
            ->join('jobs', 'jobs.candidate_id', 'candidates.id')
            ->select('candidates.*', 'addresses.*', 'education.*', 'jobs.employment')->paginate(10);
            return view('job.index', compact('candidates', 'addresses', 'education', 'jobs'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    // Getting of an apartment value
    $array = array_filter($request->apartment);
    $key_value = array_values($array);
    $apart_value = implode('',$key_value);

    // Getting of profession value
    $array = array_filter($request->profession);
    $key_value = array_values($array);
    $profession_value = implode('',$key_value);

    // Getting of start-date value
    $array = array_filter($request->start_date);
    $key_value = array_values($array);
    $start_value = implode('',$key_value);

    // Getting of start-date value
    $array = array_filter($request->end_date);
    $key_value = array_values($array);
    $end_value = implode('',$key_value);

    $candidates = Candidate::create([
        'user_id' => Auth::user()->id,
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'sex' => $request->sex,
        'age' => $request->age
    ]);

    Address::create([
        'user_id' => Auth::user()->id,
        'candidate_id' => $candidates->id,
        'city' => $request->city,
        'district' => $request->district,
        'street' => $request->street,
        'apartment' => $apart_value
    ]);

    Education::create([
        'user_id' => Auth::user()->id,
        'candidate_id' => $candidates->id,
        'education' => $request->education,
        'profession' => $profession_value,
        'start-date' => $start_value,
        'end-date' => $end_value
    ]);

    foreach($request->jobs as $job){
        Job::create([
            'user_id' => Auth::user()->id,
            'candidate_id' => $candidates->id,
            'employment' => $job
        ]);
    }

    event(new JobMail($candidates->email));
    return back()->with('success', 'მონაცემები წარმატებით გადაიგზავნა!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
