@extends('layouts.app', [
    'namePage' => 'Transactions',
    'activePage' => 'transactions',
])

@section('content')
    <form action="{{ route('merchants.transactions.index') }}" method="get" class="transactions-search-form">
        @csrf
        <div class="table-responsive">
            <div class="row">
                <div class="col-md-4">
                        <input type="search" name="search" class="form-control" placeholder="Search by name, email or phone"
                            value="{{ old('search', $searchTerm) }}">
                    </div>
                </div>
                <div class="row d-flex mt-3">
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                @php
                                    echo 'old status is ' . request()->status;
                                @endphp
                                <option value="all">All Statuses</option>
                                <option value="initiated" {{ request()->status == 'initiated' ? 'selected' : '' }}>Initiated
                                </option>
                                <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="success" {{ request()->status == 'success' ? 'selected' : '' }}>Successful
                                </option>
                                <option value="fail" {{ request()->status == 'fail' ? 'selected' : '' }}>Fail</option>
                            </select>
                        </div>
                    </div>
                    @role('admin')
                        <div class="col-md-4">
                            <div class="form-group">
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
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
    </form>

    @if (isset($searchTerm))
        <h4>Search results for: {{ $searchTerm }}</h4>
    @endif
    <p class="transaction-total">Total Amount : GHS {{ number_format($totalAmount, 2) }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                @role('admin')
                    <th>Merchant Name</th>
                @endrole
                <th>Customer Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    @role('admin')
                        <td>{{ $transaction->merchant->business_name }}</td>
                    @endrole
                    <td>{{ $transaction->customer_name }}</td>
                    <td>{{ $transaction->customer_email }}</td>
                    <td>{{ $transaction->customer_phone_number }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ Str::title($transaction->status) }}</td>
                    <td>{{ $transaction->created_at }}</td>
                </tr>
            @endforeach
            @if ($transactions->count() == 0)
                <tr>
                    <td colspan="{{ Auth::user()->hasRole('admin') ? '8' : '7' }}" class="text-center">No results found
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    {{ $transactions->links() }}
    </div>
@endsection
