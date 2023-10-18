<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>EBITS Payment - {{ $paymentPage->page_name }}</title>
    <!-- CSS Files -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.2/css/all.css" crossorigin="anonymous">
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/now-ui-dashboard.css?v=1.3.0" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/custom.css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <div class="py-5 text-center">
        <h2 class="txt-success">{{ $paymentPage->page_name }}</h2>
        <p class="lead">{{ $paymentPage->page_description }}</p>
        
        @if ($paymentPage->image)
            <img class="d-block mx-auto mb-4" src="{{ asset('images/payment-pages/'.$paymentPage->image)}}" alt="payment image here" height="72">
        @endif
    </div>

    <div class="row">
        <div class="col-md-12 order-md-1">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('assets') }}/js/core/jquery.min.js"></script>
<script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
<script src="{{ asset('assets') }}/js/now-ui-dashboard.min.js?v=1.3.0" type="text/javascript"></script>
@yield('scripts')
</html>
