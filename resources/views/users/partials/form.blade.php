<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>
    </div>
</div>

<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password <span class="text-danger">*</span></label>
            <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">
            <div class="progress">
                <div id="password-strength" class="progress-bar" role="progressbar"></div>
            </div>
            <small id="password-help" class="form-text text-muted"></small>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
        </div>
    </div>
</div>

@if(Route::currentRouteName() == 'users.create')
    <div class="form-row">
     @role('admin')
   <div class="col-md-6">
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control">

                    @foreach ($roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                        
                    @endforeach
                </select>
            </div>
        </div>
     @endrole
        <div class="col-md-6">
            <div class="form-group">
                <label for="merchant_id">Merchant</label>
                <select name="merchant_id" id="merchant_id" class="form-control">

                    @foreach ($merchants as $merchant)
                    <option value="{{$merchant->id}}">{{$merchant->business_name}}</option>
                        
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    
@endif

<button type="submit" class="btn btn-primary">Add User</button>