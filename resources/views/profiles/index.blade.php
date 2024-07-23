@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        Profiles
                        <a href="{{ route('profiles.create') }}" class="btn btn-success float-end">Add New Profile</a>
                    </div>
                    <div class="card-body">
                        @forelse($profiles as $profile)
                            <div class="mb-3 border p-3 rounded">
                                @if ($profile->image)
                                    <img src="{{ asset('storage/' . $profile->image) }}" alt="Profile Image"
                                        class="img-thumbnail mb-2" style="max-height: 150px; width: auto;">
                                @else
                                    <img src="https://via.placeholder.com/150" alt="Default Image"
                                        class="img-thumbnail mb-2">
                                @endif
                                <h5>{{ $profile->user->name }}</h5>
                                <p><strong>Education:</strong> {{ $profile->education }}</p>
                                <p><strong>Certifications:</strong> {{ $profile->certifications }}</p>
                                <p><strong>Specialties:</strong> {{ $profile->specialties }}</p>
                                <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-primary">View</a>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-center">No profiles found.</p>
                        @endforelse

                        {{ $profiles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
