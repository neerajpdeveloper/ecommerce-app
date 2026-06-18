@extends('admin.layout.app')

@section('content')

<div class="container-fluid">

    <div class="card p-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Users</h4>

            <a href="/admin/users/create" class="btn btn-primary">
                + Add User
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>
                            <td>{{ $user->email }}</td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $user->role->name ?? 'No Role' }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-success">Active</span>
                            </td>

                            <td>
                                {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </td>

                            <td>
                                <a href="/admin/users/{{ $user->id }}/role" class="btn btn-sm btn-warning">
                                    Role
                                </a>

                                <a href="#" class="btn btn-sm btn-danger">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                No users found
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection