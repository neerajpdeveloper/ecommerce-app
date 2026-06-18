<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: #111827;
            color: #fff;
        }

        .sidebar a {
            display: block;
            padding: 12px 15px;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #1f2937;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .topbar {
            background: #fff;
            padding: 10px 15px;
            margin-bottom: 20px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.1);
        }

        .card-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

@include('admin.layout.sidebar')

<div class="content">

    @include('admin.layout.header')

    @yield('content')

    @include('admin.layout.footer')

</div>

</body>
</html>