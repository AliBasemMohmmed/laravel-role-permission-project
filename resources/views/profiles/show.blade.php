@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        Profile Details
                    </div>
                    <div class="card-body">
                        @if ($profile->image)
                            <img src="{{ asset('storage/' . $profile->image) }}" alt="Profile Image" class="img-thumbnail mb-2"
                                style="max-height: 150px; width: auto;">
                        @else
                            <img src="https://via.placeholder.com/150" alt="Default Image" class="img-thumbnail mb-2">
                        @endif
                        <p><strong>Education:</strong> {{ $profile->education }}</p>
                        <p><strong>Certifications:</strong> {{ $profile->certifications }}</p>
                        <p><strong>Specialties:</strong> {{ $profile->specialties }}</p>
                        <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-secondary">Edit</a>
                        <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
