@extends('layouts.app', [
    'namePage' => 'Users',
    'activePage' => 'users',
])

@section('content')
    <div class="table-responsive">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
            </div>
            <div class="col-md-6">
                <form action="{{ route('users.index') }}" method="get">
                    <div class="form-group">
                        <input type="search" name="search" class="form-control" placeholder="Search by name" value="{{ $searchTerm }}">
                    </div>
                </form>
            </div>
        </div>
        @if (isset($searchTerm))
            <h4>Search results for: {{ $searchTerm }}</h4>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if ($users->count() == 0)
                    <tr>
                        <td colspan="3" class="text-center">No results found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection
