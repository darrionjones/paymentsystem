@extends('layouts.app', [
    'namePage' => 'Settings',
    'activePage' => 'settings',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> Settings</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <a href="{{ route('settings.create') }}" class="btn btn-success">Add Setting</a>

              <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($settings as $setting)
                        <tr>
                            <td>{{ $setting->key }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>
                                <a href="{{ route('settings.edit', $setting) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('settings.destroy', $setting) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>       
                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection