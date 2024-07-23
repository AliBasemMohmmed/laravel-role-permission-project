@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">Profile</div>
                    <div class="card-body">
                        @if ($profile)
                            <div class="mb-3 text-center">
                                @if ($profile->image)
                                    <img src="{{ asset('storage/' . $profile->image) }}" alt="Profile Image"
                                        class="img-thumbnail" width="150">
                                @else
                                    <img src="https://via.placeholder.com/150" alt="Default Image" class="img-thumbnail"
                                        width="150">
                                @endif
                                <h5 class="mt-2">{{ $profile->user->name }}</h5>
                                <p><strong>Education:</strong> {{ $profile->education }}</p>
                                <p><strong>Certifications:</strong> {{ $profile->certifications }}</p>
                                <p><strong>Specialties:</strong> {{ $profile->specialties }}</p>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        @else
                            <div class="text-center">
                                <p>No profile found. Please create a profile.</p>
                                <a href="{{ route('profiles.create') }}" class="btn btn-primary">Add Profile</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
