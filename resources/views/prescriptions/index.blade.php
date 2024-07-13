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

                        @canany(['create-dector', 'edit-dector', 'delete-dector'])
                            <a class="btn btn-success" href="{{ route('dectors.index') }}">
                                <i class="bi bi-people"></i> Manage Patient</a>
                        @endcanany
                        @canany(['create-dector', 'edit-dector', 'delete-dector'])
                        <a class="btn btn-warning" href="{{ route('prescription.index') }}">
                            <i class="bi bi-people"></i> Manage prescription</a>
                    @endcanany
                    @canany(['create-dector', 'edit-dector', 'delete-dector'])
                    <a class="btn btn-dark" href="{{ route('prescription.create') }}">
                        <i class="bi bi-people"></i> create prescription</a>
                @endcanany
                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
