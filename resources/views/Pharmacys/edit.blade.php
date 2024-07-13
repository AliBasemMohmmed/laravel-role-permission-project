
@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Edit Pharmacy
                </div>
                <div class="float-end">
                    <a href="{{ route('pharmacy.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('pharmacy.update', $Pharmacy->id) }}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $Pharmacy->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="location" class="col-md-4 col-form-label text-md-end text-start">الموقع</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                id="location" name="location" value="{{ ($Pharmacy->location) }}">
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="logo" class="col-md-4 col-form-label text-md-end text-start">
                             Image</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                id="logo" name="logo" required>
                            @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="user_id" class="col-md-4 col-form-label text-md-end text-start">اسم الدكتور</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('user_id') is-invalid @enderror"
                                id="user_id" name="user_id" value="{{$Pharmacy->user->name }}">
                            @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
