@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-info" href="{{ route('jobs.send') }}">იმფორმაციის გაგზავნა</a>
    <a href="{{ route('jobs.export') }}" class="btn btn-warning ml-5 float-right">დაექსპორტება</a>
    <form action="{{ route('jobs.index') }}" method="GET">
        @csrf
        <div class="row offset-5 my-5">
        </div>
        <div class="row">
            <div class="form-group mr-3">
                <label for="city">ქალაქი</label>
                <select name="filter_city" id="city"  class="form-control">
                  <option value=" ">აირჩიე</option>
                  @foreach ($addresses->unique('city') as $address)
                  <option value="{{ $address->city }} {{ ((request('filter_city') == 'თბილისი')) ? 'selected':''  }}" >{{ $address->city }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group mr-3">
                <label for="district">რაიონი</label>
                <select name="filter_district" id="district"  class="form-control">
                    <option value="">აირჩიე</option>
                  @foreach ($addresses->unique('district') as $address)
                  <option value="{{ $address->district }}" {{ ((request('filter_district') == $address->district)) ? 'selected':''  }}>{{ $address->district }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group mr-3">
                <label for="sex">სქესი</label>
                <select name="filter_sex" id="sex"  class="form-control">
                    <option value="">აირჩიე</option>
                    <option value="მამრობითი" {{ ((request('filter_sex') == 'მამრობითი')) ? 'selected':''  }}>მამრობითი</option>
                    <option value="მდედრობითი" {{ ((request('filter_sex') == 'მდედრობითი')) ? 'selected':''  }}>მდედრობითი</option>
                </select>
            </div>
            <div class="form-group mr-3">
                <label for="education">განათლება</label>
                <select name="filter_edu" id="education"  class="form-control">
                    <option value="">აირჩიე</option>
                  <option value="ატესტატი">ატესტატი</option>
                  @foreach ($education as $edu)
                  <option value="{{ $edu->name }}" {{ ((request('filter_edu') == $edu->name)) ? 'selected':''  }}>{{ $edu->name }}</option>
                  @endforeach
                </select>
            </div>
            <div class="form-group w-25">
                <label for="job">დასაქმების სფერო</label>
                <select name="filter_job" id="job"  class="form-control">
                    <option value="">აირჩიე</option>
                  @foreach ($jobs as $job)
                    <option value="{{ $job->name }}" {{ ((request('filter_job') == $job->name)) ? 'selected':''  }}>{{ $job->name }}</option>
                  @endforeach
              </select>
            </div>
            <div class="w-100"></div>
            <button class="btn btn-info" type="submit">გაფილტვრა</button>
        </div>
    </form>
    <div class="table-responsive">
      <table class="table table-dark table-striped mt-5">
        <thead>
          <tr>
            <th><h6>სულ: {{ $candidates->count() }}</h6></th>
          </tr>
        </thead>
        <thead class="text-center">
          <tr>
            <th>შევსების თარიღი</th>
            <th>სახელი</th>
            <th>გვარი</th>
            <th>დაბადების თარიღი</th>
            <th>მეილი</th>
            <th>ასაკი</th>
            <th>ქალაქი</th>
            <th>რაიონი</th>
            <th>განათლება</th>
            <th>დასაქმების სასურველი  სფერო</th>
          </tr>
        </thead>
        <tbody class="text-center">
            @forelse($candidates as $key=>$candidate)
              <tr>
                  <td>{{ date('F d, Y - g:i a', strtotime($candidate->created_at)) }}</td>
                  <td>{{ $candidate->name }}</td>
                  <td>{{ $candidate->surname }}</td>
                  <td>{{ $candidate->age }}</td>
                  <td>{{ $candidate->email }}</td>
                  <td>{{ $candidate->sex }}</td>
                  <td>{{ $candidate->city }}</td>
                  <td>{{ $candidate->district }}</td>
                  <td>{{ $candidate->education }}</td>
                  <td>{{ $candidate->employment }}</td>
              </tr>
            @empty
               <h5 class="text-center text-muted">კანდიდატი არ მოიძებნა!</h5>
            @endforelse
        </tbody>
      </table>
    </div>
    {!! $candidates->links() !!}
  </div>
@endsection
