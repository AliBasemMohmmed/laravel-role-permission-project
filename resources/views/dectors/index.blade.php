@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Manage patient</div>
        <div class="card-body">
            @can('create-dector')
                <a href="{{ route('dectors.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add
                    New
                    User</a>
            @endcan
            @can('create-dector')
                <a href="{{ route('dectors.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i>
                    Import
                    Excel
                    User</a>
            @endcan
            @can('create-dector')
                <a href="{{ route('dectors.create') }}" class="btn btn-dark btn-sm my-2"><i class="bi bi-plus-circle"></i> Export
                    Excel
                    User</a>
            @endcan
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">S#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Action</th>
                        <th scope="col">Prescription</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        @if ($user->hasRole('User'))
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <ul>
                                        <li>{{ $user->getRoleNames()->first() }}</li>
                                    </ul>
                                </td>
                                <td>
                                    <form action="{{ route('dectors.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        @if (in_array('dector', $user->getRoleNames()->toArray() ?? []))
                                            @if (Auth::user()->hasRole('dector'))
                                                <a href="{{ route('dectors.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>
                                                    Edit</a>
                                            @endif
                                        @else
                                            <a href="{{ route('dectors.show', $user->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                                            @can('edit-dector')
                                                <a href="{{ route('dectors.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                            @endcan


                                            @can('delete-dector')
                                                @if (Auth::user()->id != $user->id)
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Do you want to delete this user?');"><i
                                                            class="bi bi-trash"></i> Delete</button>
                                                @endif
                                            @endcan
                                            @can('edit-dector')
                                                <a href="{{ route('prescription.index', $user->id) }}"
                                                    class="btn btn-secondary btn-sm"><i
                                                        class="bi bi-pencil-square"></i>Prescription</a>
                                            @endcan
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('dectors.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        @if (in_array('dector', $user->getRoleNames()->toArray() ?? []))
                                            @if (Auth::user()->hasRole('dector'))
                                                <a href="{{ route('dectors.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>
                                                    Edit</a>
                                            @endif
                                        @else
                                            <a href="{{ route('prescription.show', $user->id) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show Prescription</a>
                                            @can('edit-dector')
                                                <a href="{{ route('prescription.create', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Create Prescription</a>
                                            @endcan

                                            @can('edit-dector')
                                            <a href="{{ route('prescription.edit', $user->id) }}"
                                                class="btn btn-secondary btn-sm"><i
                                                    class="bi bi-pencil-square"></i> show </a>
                                        @endcan
                                            @can('edit-dector')
                                                <a href="{{ route('prescription.show', $user->id) }}"
                                                    class="btn btn-secondary btn-sm"><i
                                                        class="bi bi-pencil-square"></i> ReCreat Prescription</a>
                                            @endcan
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5">
                                <span class="text-danger">
                                    <strong>No User Found!</strong>
                                </span>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            {{ $users->links() }}

        </div>
    </div>

@endsection
