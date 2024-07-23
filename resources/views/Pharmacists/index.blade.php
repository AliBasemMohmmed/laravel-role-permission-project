@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">البحث عن وصفة طبية</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('pharmacists.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="prescription_number" class="form-label">رقم الوصفة الطبية</label>
                            <input type="number" class="form-control" id="prescription_number" name="prescription_number" required>
                        </div>
                        <button type="submit" class="btn btn-primary">البحث</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
