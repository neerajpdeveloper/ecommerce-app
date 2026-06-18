@extends('admin.layout.app')

@section('content')

<div class="card p-3">

    <h4>Role: {{ $role->name }}</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="">
        @csrf

        <div class="row">

            @foreach($permissions as $permission)
            <div class="col-md-3">

                <label>
                    <input type="checkbox"
                        name="permissions[]"
                        value="{{ $permission->id }}"
                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>

                    {{ $permission->name }}
                </label>

            </div>
            @endforeach

        </div>

        <button class="btn btn-primary mt-3">Save Permissions</button>
    </form>

</div>

@endsection