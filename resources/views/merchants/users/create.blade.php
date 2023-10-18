@extends('layouts.app', [
    'namePage' => 'Add User for '.$merchant->business_name,
    'activePage' => 'add-user',
])

@section('content')
<form action="{{ route('merchants.users.store', $merchant) }}" method="POST">
    @csrf

    @include('users.partials.form');
</form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/password-strength.js') }}"></script>
@endsection
