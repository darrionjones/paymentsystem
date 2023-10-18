@extends('layouts.app', [
    'namePage' => 'Payouts',
    'activePage' => 'payouts',
])

@section('content')

   
       @livewire('payouts.initiate')
@endsection