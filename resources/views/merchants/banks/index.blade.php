@extends('layouts.app', [
    'namePage' => 'Bank Pages',
    'activePage' => 'bank-pages',
])

@section('content')
    <div class="table-responsive">
        <div class="row">
            <div class="col-md-6">

                <a href="{{ route('bank.create') }}" class="btn btn-info">Add Bank</a>

            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Bank Name</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    {{-- <th>Branch Name</th> --}}
                    {{-- <th>Actions</th> --}}
                </tr>
            </thead>
            <tbody>

                @forelse ($currentMerchant->banks as $bank)
                <tr>


                    <td>{{ $bank->bank_name }}</td>
                    @foreach ($bank->accounts as $acc)
                        <td>{{ $acc->account_name }}</td>
                        <td>{{ $acc->account_number }}</td>
                    @endforeach
                </tr>
                @empty
                    <td>No Bank Selected</td>
                @endforelse

            </tbody>
        </table>
    </div>
@endsection
