@php
    $user = auth()->user();
@endphp

<div class="sidebar">

    <a href="/admin/dashboard">Dashboard</a>

    @if($user && $user->role && $user->role->slug === 'admin')
        <a href="/admin/users">Users</a>
        <a href="/admin/roles">Roles</a>
        <a href="/admin/permissions">Permissions</a>
        <a href="/admin/products">Products</a>
        <a href="/admin/orders">Orders</a>

    @else

        @if($user && $user->role && $user->role->permissions->contains('slug','view-users'))
            <a href="/admin/users">Users</a>
        @endif

        @if($user && $user->role && $user->role->permissions->contains('slug','view-roles'))
            <a href="/admin/roles">Roles</a>
        @endif

        @if($user && $user->role && $user->role->permissions->contains('slug','view-products'))
            <a href="/admin/products">Products</a>
        @endif

        @if($user && $user->role && $user->role->permissions->contains('slug','view-orders'))
            <a href="/admin/orders">Orders</a>
        @endif

    @endif

    <a href="/admin/logout">Logout</a>

</div>