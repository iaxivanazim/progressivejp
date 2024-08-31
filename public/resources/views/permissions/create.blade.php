@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
<h2>Create Permission</h2>

<form action="{{ route('permissions.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Permission Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Create Permission</button>
</form>
@endsection