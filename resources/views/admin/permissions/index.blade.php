@extends('admin.layout.app')

@section('content')

<div class="container-fluid">

    <div class="row">

        <!-- ADD PERMISSION -->
        <div class="col-md-4">

            <div class="card p-3">
                <h4>Add Permission</h4>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="/admin/permissions/store">
                    @csrf

                    <label>Permission Name</label>
                    <input type="text" name="name" class="form-control mb-2" placeholder="Create User">

                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control mb-2" placeholder="create-user">

                    <button class="btn btn-primary w-100">Save Permission</button>
                </form>
            </div>

        </div>

        <!-- LIST -->
        <div class="col-md-8">

            <div class="card p-3">
                <h4>Permission List</h4>

                <table class="table table-bordered mt-3">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Created</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td><span class="badge bg-dark">{{ $permission->slug }}</span></td>
                            <td>{{ $permission->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</div>

@endsection