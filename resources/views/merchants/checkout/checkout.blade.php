@extends('merchants.checkout.layout')

@section('content')
    <form class="needs-validation" method="POST" action="{{ route('merchants.payment.process-checkout', $uuid) }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com">
            </div>
        </div>

        <div class="mb-3">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number" required>
        </div>

        <div class="mb-3">
            <label for="amount">Amount</label>
            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Enter the amount you want to pay" required>
        </div>

        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to payment</button>
    </form>
@endsection
