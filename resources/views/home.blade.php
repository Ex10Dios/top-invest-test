@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="card text-white bg-success mb-3 mb-md-0">
                                <a class="dashboard-link" href="{{ route('candidates.add') }}">
                                    <div class="card-body px-0">
                                        <h5 class="card-title text-center my-3">{{ __('NEW CANDIDATE') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="card text-white bg-primary mb-3 mb-md-0">
                                <a class="dashboard-link" href="{{ route('candidates.index') }}">
                                    <div class="card-body px-0">
                                        <h5 class="card-title text-center my-3">{{ __('ALL CANDIDATES') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="card text-white bg-danger mb-3 mb-md-0">
                                <a class="dashboard-link" href="{{ route('candidates.charts') }}">
                                    <div class="card-body px-0">
                                        <h5 class="card-title text-center my-3">{{ __('CHARTS') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
