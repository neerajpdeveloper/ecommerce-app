@extends('admin.layout.app')

@section('content')

<div class="card p-3">

    <h4>Change Role: {{ $user->name }}</h4>

    <form method="POST">
        @csrf

        <select name="role_id" class="form-control">
            @foreach($roles as $role)
                <option value="{{ $role->id }}"
                    {{ $user->role_id == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-primary mt-3">Update Role</button>
    </form>

</div>

@endsection