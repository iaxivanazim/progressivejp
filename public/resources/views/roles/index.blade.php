@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<div class="d-flex justify-content-between align-items-center my-4">
    <h2>Roles</h2>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Permissions</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td>
                @foreach($role->permissions as $permission)
                    <span class="badge bg-info">{{ $permission->name }}</span>
                @endforeach
            </td>
            <td>
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
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