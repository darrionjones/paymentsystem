@extends('layouts.app', [
    'namePage' => 'Add Merchant',
    'activePage' => 'add-merchant',
])

@section('content')
    <form action="{{ route('merchants.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="business_name">Business Name <span class="text-danger">*</span></label>
                    <input type="text" name="business_name" id="business_name" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" id="address" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="region">Region <span class="text-danger">*</span></label>
                    <select name="region" id="region" class="form-control" required>
                        <option value="">Select Region</option>
                        @foreach (\App\Models\Region::all() as $region)
                            <option value="{{ $region->name }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="digital_address">Digital Address <span class="text-danger">*</span></label>
                    <input type="text" name="digital_address" id="digital_address" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="business_email">Business Email <span class="text-danger">*</span></label>
                    <input type="email" name="business_email" id="business_email" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="contact_person_name">Contact Person Name <span class="text-danger">*</span></label>
                    <input type="text" name="contact_person_name" id="contact_person_name" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="contact_person_email">Contact Person Email <span class="text-danger">*</span></label>
                    <input type="email" name="contact_person_email" id="contact_person_email" class="form-control"
                        required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="contact_person_phone">Contact Person Phone <span class="text-danger">*</span></label>
                    <input type="text" name="contact_person_phone" id="contact_person_phone" class="form-control"
                        required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="is_live">Is Live <span class="text-danger">*</span></label>
                    <select name="is_live" id="is_live" class="form-control" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add Merchant</button>


    </form>
@endsection
