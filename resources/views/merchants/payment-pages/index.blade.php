@extends('layouts.app', [
    'namePage' => 'Payment Pages',
    'activePage' => 'payment-pages',
])

@section('content')
    <div class="table-responsive">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('merchants.payment-page.create') }}" class="btn btn-info">Add Payment Page</a>
            </div>
        </div>
        @if (isset($searchTerm))
            <h4>Search results for: {{ $searchTerm }}</h4>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Checkout URL</th>
                    <th>USSD Extension</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paymentPages as $page)
                    <tr>
                        <td>{{ $page->page_name }}</td>
                        <td>{{ $page->page_description }}</td>
                        <td><a href="{{ route('merchants.payment.checkout', $page->id) }}" target="_blank">{{ route('merchants.payment.checkout', $page->id) }}</a></td>
                        <td>@if ($page->ussd_extension != null)
                            {{ config('ebits.payment_ussd_code').$page->ussd_extension."#" }}
                            @endif</td>
                        <td>
                            <a href="{{ route('merchants.payment-page.edit', $page->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('merchants.payment-page.destroy', $page->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if (count($paymentPages) == 0)
                    <tr>
                        <td colspan="4" class="text-center">No payment pages found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $paymentPages->links() }}
    </div>
@endsection
