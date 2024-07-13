@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    users Information
                </div>
                <div class="float-end">
                    <a href="{{ route('dectors.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $users->name }}
                    </div>
                </div>

                <div class="row">
                    <label for="location" class="col-md-4 col-form-label text-md-end text-start"><strong>Rloe:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $users->Role }}
                    </div>
                </div>

                <div class="row">
                    <label for="logo" class="col-md-4 col-form-label text-md-end text-start"><strong>Logo:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $users->email }}
                    </div>
                </div>

                <div class="row">
                    <label for="role_id" class="col-md-4 col-form-label text-md-end text-start"><strong>Role ID:</strong></label>
                    <div class="col-md-6" style="line-height: 35px;">
                        {{ $users->role_id }}
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

@endsection
