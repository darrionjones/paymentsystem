@extends('merchants.checkout.layout')

@section('content')
    <div class="card">
        <div class="card-body">
            <iframe src="{{ $checkout_direct_url }}" frameborder="0" width="100%" height="650px"></iframe>
        </div>
    </div>
@endsection

