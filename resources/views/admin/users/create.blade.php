@extends('admin.layout.app')

@section('content')

<div class="card p-3">
    <h4>Add User</h4>

    <form method="POST" action="/admin/users/store">
        @csrf

        <input type="text" name="name" class="form-control mb-2" placeholder="Name">

        <input type="email" name="email" class="form-control mb-2" placeholder="Email">

        <input type="password" name="password" class="form-control mb-2" placeholder="Password">

        <select name="role_id" class="form-control mb-2">
            <option value="">Select Role</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>

        <button class="btn btn-success">Save User</button>
    </form>
</div>

@endsection