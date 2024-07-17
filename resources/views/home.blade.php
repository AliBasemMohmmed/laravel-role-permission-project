@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                        </p>
                        {{-- <p>This is your application dashboard.</p> --}}
                        @if (Auth::user()->hasRole('Super Admin'))
                            <p>{{ __('Number of visits: ') }}{{ Auth::user()->visits_count }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">This is your application dashboard.</h5>
                                            <!-- Add any additional content here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title"># عدد الزيارات</h5> --}}
                                            <div class="card" style="width: 18rem;">
                                                <img src="{{ asset('icon/ertyu.ico') }}" class="card-img-top"
                                                    alt="...">

                                                <div class="card-body">
                                                    <h5 class="card-title">عدد الزيارات</h5>
                                                    <p class="card-text">Some quick example text to build on the card title
                                                        and make up the bulk of the card's content.</p>
                                                    <a href="#" class="btn btn-primary">التفاصيل</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title"># عدد الصيدليات</h5> --}}
                                            <div class="card" style="width: 18rem;">
                                                <img src="{{ asset('icon/ertyu.ico') }}" class="card-img-top"
                                                    alt="...">

                                                <div class="card-body">
                                                    <h5 class="card-title">عدد الصيدليات</h5>
                                                    <p class="card-text">Some quick example text to build on the card title
                                                        and make up the bulk of the card's content.</p>
                                                    <a href="#" class="btn btn-primary">التفاصيل</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            {{-- <h5 class="card-title"># اعداد المستخدمين لكل صنف وحد</h5> --}}
                                            <div class="card" style="width: 18rem;">
                                                <img src="{{ asset('icon/ertyu.ico') }}" class="card-img-top"
                                                    alt="...">

                                                <div class="card-body">
                                                    <h5 class="card-title">اعداد المستخدمين </h5>
                                                    <p class="card-text">Some quick example text to build on the card title
                                                        and make up the bulk of the card's content.</p>
                                                    <a href="#" class="btn btn-primary">التفاصيل</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
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
    </script>
@endsection
