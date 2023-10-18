@extends('layouts.app', [
    'namePage' => 'Dashboard',
    'activePage' => 'dashboard-page',
])

@section('content')
    <div class="container-fluid px-4">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center mr-2">
                                            <i class="fas fa-wallet text-info fa-3x me-4"></i>
                                        </div>
                                        <div>
                                            <h4>Transactions Count</h4>
                                            {{-- <p class="mb-0">Transactions Count</p> --}}
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h3 mb-0">{{ number_format($transactionCount,0) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center mr-2">
                                            <i class="far fa-wallet text-warning fa-3x me-4 "></i>
                                        </div>
                                        <div>
                                            <h4>Transaction Volume</h4>
                                            {{-- <p class="mb-0">Transaction volume</p> --}}
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        GHS<h2 class="h3 mb-0">{{ number_format($totalTransaction,2) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <form action="{{ route('merchants.dashboard.index', auth()->id()) }}" method="GET">
                    <div class="form-row">
                        @role('admin')
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="merchant_id"><strong>Merchant</strong></label>
                                    <select name="merchant_id" class="form-control">
                                        <option value="">All Merchants</option>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->id }}"
                                                {{ request()->merchant_id == $merchant->id ? 'selected' : '' }}>
                                                {{ $merchant->business_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endrole
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="timeRange"><strong>Select Date</strong></label>
                                <select id="timeRange" class="form-control" name="timeRange">
                                    <option value="">Select Date</option>
                                    <option value="today" @if (request()->timeRange == 'today') selected @endif>Today</option>
                                    <option value="lastWeek" @if (request()->timeRange == 'lastWeek') selected @endif>Last Week</option>
                                    <option value="lastTwoWeeks" @if (request()->timeRange == 'lastTwoWeeks') selected @endif>Last Two Weeks</option>
                                    <option value="lastMonth" @if (request()->timeRange == 'lastMonth') selected @endif>Last Month</option>
                                    <option value="custom" @if (request()->timeRange == 'custom') selected @endif>Custom Range</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3" id="customRangeContainer"
                            @if (request()->timeRange == 'custom') style="display: block;" @else style="display: none;" @endif>
                            <div class="form-group">
                                <label for="start_date"><strong>Start Date</strong></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request()->start_date }}">
                            </div>
                        </div>
                        <div class="col-md-3" id="customRangeContainerEnd"
                            @if (request()->timeRange == 'custom') style="display: block;" @else style="display: none;" @endif>
                            <div class="form-group">
                                <label for="end_date"><strong>End Date</strong></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->end_date }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        {!! $chart->container() !!}
    </div>

    </div>

    {!! $chart->script() !!}

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#timeRange').on('change', function() {
            const customRangeContainer = $('#customRangeContainer');
            const customRangeContainerEnd = $('#customRangeContainerEnd');

            if ($(this).val() === 'custom') {
                customRangeContainer.show();
                customRangeContainerEnd.show();
            } else {
                customRangeContainer.hide();
                customRangeContainerEnd.hide();
            }
        });
    });
</script>
@endsection
