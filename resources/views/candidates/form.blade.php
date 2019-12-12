@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('candidates.index') }}">Candidates</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $candidate->getKey() ? $candidate->full_name : 'New' }}</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ $candidate->getKey() ? route('candidates.update', ['candidate' => $candidate->getKey()]) : route('candidates.store') }}">
                            @csrf
                            @if($candidate->getKey())
                                @method('PUT')
                            @endif

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name<sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?: $candidate->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="family_name" class="col-md-4 col-form-label text-md-right">Family Name'<sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="family_name" type="text" class="form-control @error('family_name') is-invalid @enderror" name="family_name" value="{{ old('family_name') ?: $candidate->family_name }}" required>

                                    @error('family_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address<sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?: $candidate->email }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">Phone<sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') ?: $candidate->phone }}" required>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="average_salary" class="col-md-4 col-form-label text-md-right">Average Salary<sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="average_salary" type="number" min="0" class="form-control @error('average_salary') is-invalid @enderror" name="average_salary" value="{{ old('average_salary') ?: $candidate->average_salary }}" required>

                                    @error('average_salary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">Gender<sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                                        @php
                                            $gender = old('gender') ?: $candidate->gender;
                                        @endphp
                                        <option value="Male"   {{ ($gender == 'Male'   ? "selected":"") }}>Male</option>
                                        <option value="Female" {{ ($gender == 'Female' ? "selected":"") }}>Female</option>
                                        <option value="Other"  {{ ($gender == 'Other'  ? "selected":"") }}>Other</option>
                                    </select>

                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="birth_date" class="col-md-4 col-form-label text-md-right">Birth Date<sup class="text-danger">*</sup></label>

                                <div class="col-md-6">
                                    <input id="birth_date" type="date" min="1000-01-01" max="{{ date('Y-m-d') }}" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') ?: $candidate->birth_date }}" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">

                                    @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $candidate->getKey() ? 'Update' : 'Save' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
