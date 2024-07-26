@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <form action="{{ route('reservations.index') }}" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search for doctors or pharmacies"
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <div class="row">
            @foreach ($doctors as $doctor)
                <div class="col-md-3">
                    <div class="card mb-4 shadow-sm">
                        @if ($doctor->profile->image)
                            <img src="{{ asset('storage/' . $doctor->profile->image) }}" alt="Profile Image"
                                class="img-thumbnail mb-2" style="max-height: 150px; width: auto;">
                        @else
                            <img src="https://via.placeholder.com/150" alt="Default Image" class="img-thumbnail mb-2">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $doctor->name }}</h5>
                            <p class="card-text"><strong>Pharmacy:</strong> {{ $doctor->pharmacy->name }}</p>
                            <p class="card-text"><strong>Location:</strong> {{ $doctor->pharmacy->location }}</p>
                            <a href="{{ route('reservations.show', $doctor->id) }}" class="btn btn-primary">More Info</a>
                            {{-- <a href="{{ route('appointment.book', $doctor->id) }}" class="btn btn-success">Book
                                Appointment</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
