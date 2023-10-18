@extends('layouts.app', [
    'namePage' => 'Merchants',
    'activePage' => 'merchants',
])

@section('content')
    <div class="table-responsive">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ route('merchants.create') }}" class="btn btn-info">Add Merchant</a>
            </div>
            <div class="col-md-6">
                <form action="{{ route('merchants.index') }}" method="get">
                    <div class="form-group">
                        <input type="search" name="search" class="form-control" placeholder="Search by merchant name"
                            value="{{ $searchTerm }}">
                    </div>
                </form>
            </div>
        </div>
        @if (isset($searchTerm))
            <h4>Search results for: {{ $searchTerm }}</h4>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Business Name</th>
                    <th>Address</th>
                    <th>Region</th>
                    <th>Digital Address</th>
                    <th>Business Email</th>
                    <th>Contact Person Name</th>
                    <th>Contact Person Email</th>
                    <th>Contact Person Phone</th>
                    <th>Commission</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($merchants as $merchant)
                    <tr>
                        <td>{{ $merchant->business_name }}</td>
                        <td>{{ $merchant->address }}</td>
                        <td>{{ $merchant->region }}</td>
                        <td>{{ $merchant->digital_address }}</td>
                        <td>{{ $merchant->business_email }}</td>
                        <td>{{ $merchant->contact_person_name }}</td>
                        <td>{{ $merchant->contact_person_email }}</td>
                        <td>{{ $merchant->contact_person_phone }}</td>
                        <td>{{ $merchant->commission }}</td>
                        <td>
                            <a href="{{ route('merchants.show', $merchant) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('merchants.edit', $merchant) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('merchants.destroy', $merchant) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger delete-button">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if (count($merchants) == 0)
                    <tr>
                        <td colspan="9" class="text-center">No merchants found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{ $merchants->links() }}
    </div>
@endsection
