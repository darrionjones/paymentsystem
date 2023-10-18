@extends('layouts.app', [
    'namePage' => 'New Payment Page',
    'activePage' => 'payment-pages',
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="{{ route('merchants.payment-page.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Page Name <span class="text-danger">*</span></label>
                            <input type="text" name="page_name" class="form-control" placeholder="Page Name"
                                value="{{ old('page_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Payment Type <span class="text-danger">*</span></label>
                            <select name="payment_type" class="form-control" required>
                                <option value="">Select Payment Type</option>
                                <option value="one-time">One Time Payment</option>
                                <option value="recurring">Recurring Payment</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Enable USSD Payment <span class="text-danger">*</span></label>
                            <select name="ussd_payment" class="form-control" required>
                                <option value="">Select an Option</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Page Description</label>
                            <textarea name="page_description" class="form-control" placeholder="Page Description">{{ old('page_description') }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Page Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-success">Create Payment Page</button>
            </form>
        </div>
    </div>
@endsection
