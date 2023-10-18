@extends('layouts.app', [
    'namePage' => {{ $user->name }},
    'activePage' => 'users',
])

@section('content')
    <div class="table-responsive">
        <a href="{{ route('asset_categories.index') }}" class="btn btn-info">Back</a>
        <a href="{{ route('asset_categories.edit', ['assetCategory' => $category->id]) }}"
            class="btn btn-secondary"  title="Edit"><i class="fa fa-edit"></i></a>
        <form action="{{ route('asset_categories.destroy', ['assetCategory' => $category->id]) }}" method="post" style="display: inline">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger delete-button"  title="Delete"><i class="fa fa-trash"></i></button>
        </form>
        
        <table class="table">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $category->name }}</td>
                </tr>
                <tr>
                    <th>Code</th>
                    <td>{{ $category->code }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $category->description }}</td>
                </tr>
                <tr>
                    <th>Intangible Category</th>
                    <td>{{ ucfirst($category->intangible_category) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
