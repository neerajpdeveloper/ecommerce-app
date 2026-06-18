@extends('admin.layout.app')

@section('content')

<div class="container-fluid">

    <div class="row">

        <!-- ADD ROLE FORM -->
        <div class="col-md-4">

            <div class="card p-3 shadow-sm">

                <h4 class="mb-3">➕ Add Role</h4>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="/admin/roles/store">
                    @csrf

                    <label class="form-label">Role Name</label>
                    <input type="text" name="name" class="form-control mb-2" placeholder="Admin">

                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control mb-3" placeholder="admin">

                    <button class="btn btn-primary w-100">
                        Save Role
                    </button>
                </form>

            </div>

        </div>

        <!-- ROLE LIST -->
        <div class="col-md-8">

            <div class="card p-3 shadow-sm">

                <h4 class="mb-3">📋 Role List</h4>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Role Name</th>
                                <th>Slug</th>
                                <th>Permissions</th>
                                <th>Created At</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>

                                    <td>
                                        <strong>{{ $role->name }}</strong>
                                    </td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $role->slug }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-info">
                                            {{ $role->permissions->count() ?? 0 }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $role->created_at ? $role->created_at->format('d M Y') : '-' }}
                                    </td>

                                    <td>
                                        <a href="/admin/roles/{{ $role->id }}/permissions"
                                           class="btn btn-sm btn-warning">
                                            Permissions
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No roles found
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection