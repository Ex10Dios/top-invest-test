@extends('layouts.app')

@section('scripts')
    <script src="/js/Chart.min.js"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="/css/Chart.min.css" />
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('candidates.index') }}">{{ __('Candidates') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('Charts') }}</li>
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
                            <div class="col-12 mb-5">
                                <h2 class="text-secondary">Gender as a function of age</h2>
                                <canvas id="gender_age" width="400" height="200"></canvas>
                            </div>
                            <div class="col-12 mb-5">
                                <h2 class="text-secondary">Average salary as a function of age</h2>
                                <canvas id="salary_age" width="400" height="200"></canvas>
                            </div>
                            <div class="col-12">
                                <h2 class="text-secondary">Average salary as function of gender</h2>
                                <canvas id="salary_gender" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        'use strict';

        const candidates = {!! json_encode($candidates) !!};

        // Drag Gender/Age chart
        //----------------------------------------------------------

        let gender_age = document.getElementById('gender_age');
        let gender_age_labels = [];
        let gender_age_data = {
            male: {},
            female: {},
            other: {},
        };
        let gender_age_dataset = [
            {
                label: "Male",
                backgroundColor: 'rgba(108, 187, 240, 0.2)',
                borderColor: 'rgba(108, 187, 240, 1)',
                borderWidth: 1,
                data: []
            },
            {
                label: "Female",
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: []
            },
            {
                label: "Other",
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1,
                data: []
            }
        ];
        candidates.forEach((candidate) => {
            if (!gender_age_labels.includes(candidate.age)) {
                gender_age_labels.push(candidate.age);
            }
            switch (candidate.gender) {
                case 'Male':
                    if (gender_age_data.male[candidate.age]) {
                        gender_age_data.male[candidate.age]++;
                    } else {
                        gender_age_data.male[candidate.age] = 1;
                    }
                    break;
                case 'Female':
                    if (gender_age_data.female[candidate.age]) {
                        gender_age_data.female[candidate.age]++;
                    } else {
                        gender_age_data.female[candidate.age] = 1;
                    }
                    break;
                default:
                    if (gender_age_data.other[candidate.age]) {
                        gender_age_data.other[candidate.age]++;
                    } else {
                        gender_age_data.other[candidate.age] = 1;
                    }
            }
        });
        gender_age_labels.sort((a, b) => a - b);
        gender_age_labels.forEach((age, index) => {
            gender_age_dataset[0].data[index] = gender_age_data.male[age] ? gender_age_data.male[age] : 0;
            gender_age_dataset[1].data[index] = gender_age_data.female[age] ? gender_age_data.female[age] : 0;
            gender_age_dataset[2].data[index] = gender_age_data.other[age] ? gender_age_data.other[age] : 0;
        });
        let gender_age_chart = new Chart(gender_age, {
            type: 'bar',
            data: {
                labels: gender_age_labels,
                datasets: gender_age_dataset,
            },
            options: {
                barValueSpacing: 20,
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                }
            }
        });


        // // Drag Salary/Age chart
        // //----------------------------------------------------------

        let salary_age = document.getElementById('salary_age');
        let salary_age_labels = [];
        let salary_age_data = {};
        let salary_age_dataset = [{
            data: [],
            label: 'Average Salary',
            borderColor: 'rgba(55, 205, 83, 1)',
            backgroundColor: 'rgba(55, 205, 83, 0.2)',
        }];
        candidates.forEach((candidate) => {
            if (salary_age_data[candidate.age]) {
                salary_age_data[candidate.age].push(candidate.average_salary);
            } else {
                salary_age_data[candidate.age] = [candidate.average_salary];
            }
        });
        salary_age_labels = Object.keys(salary_age_data);
        salary_age_labels.forEach((age) => {
            salary_age_dataset[0].data.push(
                salary_age_data[age].reduce( ( p, c ) => p + c, 0 ) / salary_age_data[age].length
            );
        });
        let salary_age_chart = new Chart(salary_age, {
            type: 'line',
            data: {
                labels: salary_age_labels,
                datasets: salary_age_dataset,
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 0,
                        }
                    }]
                }
            }
        });


        // // Drag Salary/Gender chart
        // //----------------------------------------------------------

        let salary_gender = document.getElementById('salary_gender');
        let salary_gender_data = {
            male: [],
            female: [],
            other: [],
        };
        let salary_gender_dataset = [{
            data: [],
            label: 'Average Salary',
            borderColor: [
                'rgba(108, 187, 240, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            backgroundColor: [
                'rgba(108, 187, 240, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
        }];
        candidates.forEach((candidate) => {
            switch (candidate.gender) {
                case 'Male':
                    salary_gender_data.male.push(candidate.average_salary);
                    break;
                case 'Female':
                    salary_gender_data.female.push(candidate.average_salary);
                    break;
                default:
                    salary_gender_data.other.push(candidate.average_salary);
            }
        });
        salary_gender_dataset[0].data[0] = salary_gender_data.male.reduce( ( p, c ) => p + c, 0 ) / salary_gender_data.male.length;
        salary_gender_dataset[0].data[1] = salary_gender_data.female.reduce( ( p, c ) => p + c, 0 ) / salary_gender_data.female.length;
        salary_gender_dataset[0].data[2] = salary_gender_data.other.reduce( ( p, c ) => p + c, 0 ) / salary_gender_data.other.length;
        let salary_gender_chart = new Chart(salary_gender, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female', "Other"],
                datasets: salary_gender_dataset,
            },
        });
    </script>
@endsection
