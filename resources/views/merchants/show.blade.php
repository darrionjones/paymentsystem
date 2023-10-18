@extends('layouts.app', [
    'namePage' => $merchant->business_name.'\'s Details',
    'activePage' => 'view-asset-category',
])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $merchant->business_name }}</div>

                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Business Name</th>
                                <td>{{ $merchant->business_name }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $merchant->address }}</td>
                            </tr>
                            <tr>
                                <th>Region</th>
                                <td>{{ $merchant->region }}</td>
                            </tr>
                            <tr>
                                <th>Digital Address</th>
                                <td>{{ $merchant->digital_address }}</td>
                            </tr>
                            <tr>
                                <th>Business Email</th>
                                <td>{{ $merchant->business_email }}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Name</th>
                                <td>{{ $merchant->contact_person_name }}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Email</th>
                                <td>{{ $merchant->contact_person_email }}</td>
                            </tr>
                            <tr>
                                <th>Contact Person Phone</th>
                                <td>{{ $merchant->contact_person_phone }}</td>
                            </tr>
                            <tr>
                                <th>Is Live</th>
                                <td>{{ $merchant->is_live ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <th>Client ID</th>
                                <td>{{ $merchant->client_id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Client Secret</th>
                                <td>{{ $merchant->client_secret ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-right">
                        <form action="{{ route('merchants.generate-credentials', $merchant) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Re-Generate Client ID and Client Secret</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $merchant->business_name }} Users</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($merchant->users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->roles[0]->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-right">
                        <a href="{{ route('merchants.users.create', $merchant) }}" class="btn btn-primary">Add User</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

