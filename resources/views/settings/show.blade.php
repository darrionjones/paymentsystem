@extends('layouts.app', [
    'namePage' => 'View Asset Location',
    'activePage' => 'view-asset-location',
])

@section('content')
  <div class="panel-header panel-header-sm">
  </div>
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title"> View Asset Location</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $location->name }}</td>
                    </tr>
                    <tr>
                      <th>Code</th>
                      <td>{{ $location->code }}</td>
                  </tr>                    
                    <tr>
                        <th>Location</th>
                        <td>{{ $location->location }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('asset_locations.index') }}" class="btn btn-default">Back</a>
            <a href="{{ route('asset_locations.edit', ['assetLocation' => $location->id]) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('asset_locations.destroy', ['assetLocation' => $location->id]) }}" method="POST" style="display: inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection