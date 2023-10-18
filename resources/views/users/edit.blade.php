@extends('layouts.app', [
    'namePage' => 'Edit User',
    'activePage' => 'edit-user',
])

@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
    </div>

    <div class="form-group">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
    </div>
    
    <div class="form-group">
        <label for="password">Password </label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password </label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update User</button>
</form>
@endsection
