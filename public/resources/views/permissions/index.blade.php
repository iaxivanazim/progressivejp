@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
<div class="d-flex justify-content-between align-items-center my-4">
    <h2>Permissions</h2>
    <a href="{{ route('permissions.create') }}" class="btn btn-primary">Create Permission</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->name }}</td>
            <td>
                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection