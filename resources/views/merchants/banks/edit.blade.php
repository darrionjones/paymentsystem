@extends('layouts.app', [
    'namePage' => 'Add Bank',
    'activePage' => 'add-bank',
])

@section('content')
    <form action="{{ route('bank.update',$bank->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="account_number">Account Number<span class="text-danger">*</span></label>
                    <input type="text"  value="{{$bank->account_number}}" name="account_number" id="account_number" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="account_name">Account Name <span class="text-danger">*</span></label>
                    <input type="text"  value="{{$bank->account_name}}" name="account_name" id="account_name" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label for="bank_name">Bank Name <span class="text-danger">*</span></label>
                    <input type="text" value="{{$bank->bank_name}}" name="bank_name" id="bank_name" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="branch_name">Branch Name <span class="text-danger">*</span></label>
                    <input type="text"  value="{{$bank->branch_name}}" name="branch_name" id="branch_name" class="form-control" required>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Update Bank</button>


    </form>
@endsection
