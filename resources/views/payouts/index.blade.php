@extends('layouts.app', [
    'namePage' => 'Payouts',
    'activePage' => 'payouts',
])

@section('content')
    @include('includes.payouts.status')
    @livewire('payouts.initiated')
@endsection
