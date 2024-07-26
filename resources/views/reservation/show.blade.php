@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Doctor Details</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if ($doctor->profile->image)
                            <img src="{{ asset('storage/' . $doctor->profile->image) }}" alt="Profile Image"
                                class="img-thumbnail mb-2">
                        @else
                            <img src="https://via.placeholder.com/150" alt="Default Image" class="img-thumbnail mb-2">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h5>Name: {{ $doctor->name }}</h5>
                        <p>Email: {{ $doctor->email }}</p>
                        <p>Pharmacy: {{ $doctor->pharmacy->name }}</p>
                        <p>Location: {{ $doctor->pharmacy->location }}</p>
                        <h5>Profile</h5>
                        <p>Education: {{ $doctor->profile->education }}</p>
                        <p>Certifications: {{ $doctor->profile->certifications }}</p>
                        <p>Specialties: {{ $doctor->profile->specialties }}</p>
                        <h5>Settings</h5>
                        <p>Work Hours: {{ $doctor->settings->start_time }} - {{ $doctor->settings->end_time }}</p>
                        <p>Work Days: {{ implode(', ', $doctor->settings->working_days ?? []) }}</p>
                        <p>Vacation Days: {{ implode(', ', $doctor->settings->vacation_days ?? []) }}</p>
                        <p>Patient Limit: {{ $doctor->settings->daily_patient_limit }}</p>
                    </div>
                </div>
                <a href="{{ route('appointment.book', $doctor->id) }}" class="btn btn-success mt-3">Book Appointment</a>
            </div>
        </div>
    </div>
@endsection
