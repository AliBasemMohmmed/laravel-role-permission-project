@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">{{ __('Dashboard') }}</h4>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <p>{{ __('You are logged in!') }}</p>
                        @canany(['create-role', 'edit-role', 'delete-role'])
                            <a class="btn btn-primary" href="{{ route('roles.index') }}">
                                <i class="bi bi-person-fill-gear"></i> Manage Roles</a>
                        @endcanany
                        @canany(['create-pharmacy', 'edit-pharmacy', 'delete-pharmacy'])
                            <a class="btn btn-dark" href="{{ route('pharmacy.index') }}"> <i class="bi bi-people"></i>Manage
                                Pharmacy</a>
                        @endcanany
                        @canany(['create-user', 'edit-user', 'delete-user'])
                            <a class="btn btn-secondary" href="{{ route('users.index') }}">
                                <i class="bi bi-secondary"></i> Manage Users</a>
                        @endcanany
                        @canany(['create-dector', 'edit-dector', 'delete-dector'])
                            <a class="btn btn-danger" href="{{ route('dectors.index') }}">
                                <i class="bi bi-people"></i> Manage Patient</a>
                        @endcanany

                        @canany(['create-product', 'edit-product', 'delete-product'])
                            <a class="btn btn-warning" href="{{ route('products.index') }}">
                                <i class="bi bi-basket-fill"></i> Manage Products</a>
                        @endcanany
                        @can(['view-patient'])
                            <a class="btn btn-info" href="{{ route('patients.index') }}">
                                <i class="bi bi-warning"></i> View Products</a>
                        @endcan
                        {{-- @if (Auth::user()->hasRole('Doctor'))
                        @can(['view-pharmacy'])
                            <a class="btn btn-info" href="{{ route('pharmacy.show', Auth::user()->id) }}">
                                <i class="bi bi-bandaid-fill"></i> View My Pharmacy</a>
                        @endcan
                    @endif --}}
                        @if (Auth::user()->hasRole('User'))
                            @include('patient.patientshow')
                            @can(['view-description'])
                                <a class="btn btn-secondary" href="{{ route('patients.show', Auth::user()->id) }}">
                                    <i class="bi bi-bag"></i> View My Pharmacy</a>
                            @endcan
                        @endif

                        <p>&nbsp;</p>
                        @if (Auth::user()->hasRole('Super Admin'))
                            <h5 class="mb-3">{{ __('Number of visits: ') }}{{ $numberOfVisits }}</h5>

                            <div class="row mb-4">
                                <div class="col-md-4 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">عدد الصيدليات</h5>
                                            <p class="card-text">{{ $numberOfPharmacies }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">عدد المشرفين</h5>
                                            <p class="card-text">{{ $numberOfUsers['superAdmin'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">عدد الإداريين</h5>
                                            <p class="card-text">{{ $numberOfUsers['Admin'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">عدد الأطباء</h5>
                                            <p class="card-text">{{ $numberOfUsers['Doctor'] }}</p>
                                            {{-- <div>
                                                @foreach (auth()->user()->notifications as $notification)
                                                    <div class="alert alert-info">
                                                        {{ $notification->data['appointment_id'] }} -
                                                        {{ $notification->data['appointment_date'] }} -
                                                        {{ $notification->data['appointment_time'] }}
                                                    </div>
                                                @endforeach

                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">عدد مديري المنتجات</h5>
                                            <p class="card-text">{{ $numberOfUsers['productManager'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">عدد المرضى</h5>
                                            <p class="card-text">{{ $numberOfUsers['patient'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container mb-4">
                                <h1 class="text-center mb-4">نمو عدد المستخدمين والاشتراكات</h1>

                                <div class="row">
                                    <div class="col-md-6">
                                        <canvas id="userGrowthChart"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <canvas id="signUpGrowthChart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
                                    const signUpGrowthCtx = document.getElementById('signUpGrowthChart').getContext('2d');

                                    const userGrowthChart = new Chart(userGrowthCtx, {
                                        type: 'line',
                                        data: {
                                            labels: @json($userGrowthLabels),
                                            datasets: [{
                                                label: 'نمو عدد المستخدمين',
                                                data: @json($userGrowthData),
                                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                                borderColor: 'rgba(54, 162, 235, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });

                                    const signUpGrowthChart = new Chart(signUpGrowthCtx, {
                                        type: 'line',
                                        data: {
                                            labels: @json($signUpGrowthLabels),
                                            datasets: [{
                                                label: 'نمو الاشتراكات',
                                                data: @json($signUpGrowthData),
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>

                            <div class="container mb-4">
                                <h1 class="text-center mb-4">عدد الزيارات</h1>
                                <canvas id="visitsChart"></canvas>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var ctx = document.getElementById('visitsChart').getContext('2d');
                                    var visitsChart = new Chart(ctx, {
                                        type: 'bar',
                                        data: {
                                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                            datasets: [{
                                                label: 'Visits',
                                                data: [65, 59, 80, 81, 56, 55, 40],
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
