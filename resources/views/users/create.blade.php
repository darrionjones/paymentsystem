@extends('layouts.app', [
    'namePage' => 'Add User',
    'activePage' => 'add-user',
])

@section('content')
<form action="{{ route('users.store') }}" method="POST" id="add-user-form">
    @csrf

    @include('users.partials.form')
</form>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/password-strength.js') }}"></script>
@endsection
