@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 animate__animated animate__bounceInDown">
            <a class="btn btn-info" href="{{ route('jobs.index') }}">კანდიდატთა ლისტის ნახვა</a>
            @if(Session::has('success'))
            <div class="alert alert-success my-3 text-center animate__animated animate__bounceIn">
                {{ Session::get('success') }}
            </div>
            @endif
            <form action="{{ route('jobs.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">სახელი:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="surname">გვარი:</label>
                    <input type="text" name="surname" id="surname" value="{{ old('surname') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="birthday">დაბადების თარიღი:</label>
                    <input type="text" id="dob" class="form-control" required>
                    <input type="text" name="age" id="age" value="{{ old('age') }}"  class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="sex">სქესი:</label>
                    <select class="form-control" name="sex" id="sex" required>
                        <option {{ (old('sex') == 'მამრობითი') ? "selected" : "" }} value="მამრობითი">მამრობითი</option>
                        <option {{ (old('sex') == 'მდედრობითი') ? "selected" : "" }} value="მდედრობითი">მდედრობითი</option>
                    </select>
                  </div>
                <div class="dropdown mb-3">
                    <button class="btn btn-info dropdown-toggle w-100" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      მისამართი
                    </button>
                    
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        @foreach ($addresses->unique('city') as $city)
                        <li class="dropdown-submenu">
                            <a  class="dropdown-item" tabindex="-1" href="#"><input type="radio" name="city"  value="{{ $city->city }}" id="">{{ $city->city }}</a>
                            <ul class="dropdown-menu">
                                @foreach ($addresses->unique('district') as $district)
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#"><input type="radio" class="mr-2" name="district"  value="{{ $district->district }}" id="">{{ $district->district }}</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($addresses->where('district', $district->district) as $streets)
                                        <li class="dropdown-submenu">
                                            <a class="dropdown-item" href="#"><input type="radio" class="mr-2" name="street"  value="{{ $streets->street }}" id="">{{ $streets->street }}</a>
                                            <ul class="dropdown-menu">
                                                <li class="dropdown-item">
                                                    <input type="text" name="apartment[]" value="" class="form-control" id="" >
                                                </li>
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>

                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="form-group">
                    <label for="email">მეილი:</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                
                {{-- Education Section--}}
                <div class="dropdown">
                    <button class="btn btn-info dropdown-toggle w-100" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    განათლება
                    </button>
                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                        <a  class="dropdown-item" tabindex="-1" href="#" disabled><input type="radio" name="education"  value="ატესტატი" id="education">ატესტატი</a>
                        @foreach ($education->unique('name') as $edu)
                            <li class="dropdown-submenu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item" href="#"><input type="radio" name="education"  value="{{ $edu->name }}" id="education">{{ $edu->name }}</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-item">
                                            <input type="text" name="profession[]" class="form-control" id="profession" >
                                            <input type="date" name="start_date[]" class="form-control" id="start-date" >
                                            <input type="date" name="end_date[]" class="form-control" id="end-date" >
                                        </li>
                                    </ul>
                                </li>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Jobs --}}
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="jobs">დასაქმების სასურველი სფერო:</label>
                            <select class="form-control" name="jobs[]" id="jobs" multiple required>
                                @foreach ($jobs as $job)
                                    <option value="{{ $job }}">{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-success" type="submit">გაგზავნა</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('js/birthday.js') }}"></script>
@endsection
