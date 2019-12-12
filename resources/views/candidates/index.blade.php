@extends('layouts.app')

@section('content')
    <div class="container" id="candidates_index">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Candidates</li>
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
                            <div class="col-12 mb-3">
                                <a href="{{ route('candidates.add') }}">
                                    <button type="button" class="btn btn-primary">Add New</button>
                                </a>
                                <form class="form-inline float-right" id="candidates_search_form" method="GET">
                                    <input
                                            class="form-control"
                                            type="search"
                                            placeholder="Search"
                                            aria-label="Search"
                                            name="search"
                                            value="{{ $search }}"
                                            onchange="document.getElementById('candidates_search_form').submit();">
                                </form>
                                <a href="{{ route('candidates.export') }}" target="_blank" class="float-right mr-3" title="Export to CSV">
                                    <button type="button" class="btn btn-outline-primary">CSV</button>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 candidates-table-container">
                                <table class="table table-hover candidates-table mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Av. Salary</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Birth Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $key => $candidate)
                                        <tr>
                                            <td>
                                                <a class="no-decoration" href="{{ route('candidates.edit', ['candidate' => $candidate->getKey()]) }}" title="Edit">
                                                {{ $candidate->full_name }}
                                                </a>
                                            </td>
                                            <td>{{ $candidate->age }}</td>
                                            <td>{{ $candidate->email }}</td>
                                            <td>{{ $candidate->phone }}</td>
                                            <td>{{ $candidate->average_salary }}</td>
                                            <td>{{ $candidate->gender }}</td>
                                            <td>{{ $candidate->birth_date }}</td>
                                        </tr>
                                    @endforeach

                                    @if(count($data) === 0)
                                        <tr>
                                            <td colspan="7" class="text-center"><span class="text-secondary">No data to display</span></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
