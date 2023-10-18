@extends('layouts.app', [
    'namePage' => 'Edit Settings',
    'activePage' => 'edit-settings',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> Edit Setting</h4>
          </div>
          <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('settings.update', $setting) }}">
              @csrf
              @method('PATCH')

              <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
                  <label for="key" class="col-md-4 control-label">Key</label>

                  <div class="col-md-6">
                      <input id="key" type="text" class="form-control" name="key" value="{{ $setting->key }}" required autofocus>

                      @if ($errors->has('key'))
                          <span class="help-block">
                              <strong>{{ $errors->first('key') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                  <label for="value" class="col-md-4 control-label">Value</label>

                  <div class="col-md-6">
                      <input id="value" type="text" class="form-control" name="value" value="{{ $setting->value }}" required>

                      @if ($errors->has('value'))
                          <span class="help-block">
                              <strong>{{ $errors->first('value') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group">
                  <div class="col-md-6 col-md-offset-4">
                      <button type="submit" class="btn btn-primary">
                          Update
                      </button>
                  </div>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection