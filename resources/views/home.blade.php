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

                        <p>This is your application dashboard.</p>
                        @if (Auth::user()->hasRole('Super Admin'))
                            <p># عدد الزيارات</p>
                            <p>#عدد الصيدليات </p>
                            <p>#اعداد المستخدمين لكل صنف وحد</p>
                            <p>This is your application dashboard.</p>
                        @endif

                        @canany(['create-role', 'edit-role', 'delete-role'])
                            <a class="btn btn-primary" href="{{ route('roles.index') }}">
                                <i class="bi bi-person-fill-gear"></i> Manage Roles</a>
                        @endcanany
                        @canany(['create-pharmacy', 'edit-pharmacy', 'delete-pharmacy'])
                            <li><a class="nav-link" href="{{ route('pharmacy.index') }}">Manage Pharmacy</a></li>
                        @endcanany
                        @canany(['create-user', 'edit-user', 'delete-user'])
                            <a class="btn btn-success" href="{{ route('users.index') }}">
                                <i class="bi bi-people"></i> Manage Users</a>
                        @endcanany
                        @canany(['create-dector', 'edit-dector', 'delete-dector'])
                            <a class="btn btn-warning" href="{{ route('dectors.index') }}">
                                <i class="bi bi-people"></i> Manage Patient</a>
                        @endcanany

                        @canany(['create-product', 'edit-product', 'delete-product'])
                            <a class="btn btn-warning" href="{{ route('products.index') }}">
                                <i class="bi bi-bag"></i> Manage Products</a>
                        @endcanany
                        @can(['view-patient'])
                            <a class="btn btn-warning" href="{{ route('patients.index') }}">
                                <i class="bi bi-bag"></i> View Products</a>
                        @endcan
                        @if (Auth::user()->hasRole('Doctor'))
                            @can(['view-pharmacy'])
                                <a class="btn btn-secondary" href="{{ route('pharmacy.show', Auth::user()->id) }}">
                                    <i class="bi bi-bag"></i> View My Pharmacy</a>
                            @endcan
                        @endif
                        @if (Auth::user()->hasRole('User'))
                            {{-- @can(['view-prescription'])
                                <a class="btn btn-secondary" href="{{ route('patients.index') }}">
                                    <i class="bi bi-bag"></i> View My Pharmacy</a>
                            @endcan --}}
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
@endsection
