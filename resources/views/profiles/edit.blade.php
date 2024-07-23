@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">Edit Profile</div>
                    <div class="card-body">
                        <form action="{{ route('profiles.update', $profile->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($profile->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $profile->image) }}" alt="Profile Image"
                                            class="img-thumbnail" width="150">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="education" class="form-label">Education</label>
                                <textarea class="form-control" id="education" name="education" required>{{ old('education', $profile->education) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="certifications" class="form-label">Certifications</label>
                                <textarea class="form-control" id="certifications" name="certifications" required>{{ old('certifications', $profile->certifications) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="specialties" class="form-label">Specialties</label>
                                <textarea class="form-control" id="specialties" name="specialties" required>{{ old('specialties', $profile->specialties) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
