@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<h2>Create Role</h2>

<form action="{{ route('roles.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Role Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="permissions">Assign Permissions</label>
        @foreach($permissions as $permission)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                <label class="form-check-label">
                    {{ $permission->name }}
                </label>
            </div>
        @endforeach
    </div>

    <button type="submit" class="btn btn-primary">Create Role</button>
</form>
@endsection