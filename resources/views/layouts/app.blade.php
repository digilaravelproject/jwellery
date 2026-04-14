<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jewellery Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #d4af37;
            --dark-bg: #1a1a1a;
            --light-bg: #f8f9fa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: #333;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #2d2d2d 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            font-weight: 700;
            font-size: 24px;
            color: var(--primary-color) !important;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .navbar .nav-link {
            color: #fff !important;
            margin-left: 20px;
            transition: color 0.3s;
            position: relative;
        }

        .navbar .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s;
        }

        .navbar .nav-link:hover::after {
            width: 100%;
        }

        /* Container */
        .container-main {
            min-height: 100vh;
            background: linear-gradient(to bottom, var(--light-bg) 0%, #fff 100%);
        }

        /* Footer */
        footer {
            background-color: var(--dark-bg);
            color: #fff;
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
            border-top: 2px solid var(--primary-color);
        }

        footer p {
            margin: 0;
            font-size: 14px;
        }

        /* Alerts */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        /* Common Styling */
        h1, h2, h3, h4, h5, h6 {
            color: var(--dark-bg);
            font-weight: 700;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--dark-bg);
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #c69e2e;
            border-color: #c69e2e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
            transform: translateY(-2px);
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            transition: all 0.3s;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #138496;
            transform: translateY(-2px);
        }

        /* Form Styling */
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px 15px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-bg);
            margin-bottom: 8px;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background: linear-gradient(135deg, #d4af37 0%, #c69e2e 100%);
            color: var(--dark-bg);
            border-radius: 12px 12px 0 0 !important;
            border: none;
            padding: 20px;
            font-weight: 700;
        }

        /* Badge Styling */
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        /* Table Styling */
        .table {
            background-color: white;
        }

        .table th {
            background-color: var(--dark-bg);
            color: var(--primary-color);
            font-weight: 700;
            border: none;
            padding: 15px;
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
            border-color: #eee;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding-left: 0;
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--dark-bg);
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar .nav-link {
                margin-left: 0;
                margin-top: 10px;
            }

            h1 {
                font-size: 28px;
            }

            .card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-gem"></i> Jewellery
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <span class="nav-link">Welcome, {{ Auth::user()->name }}!</span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="nav-link" style="border:none; background:none; cursor:pointer;">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signin') }}">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('signup') }}">Sign Up</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/login">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <div class="container py-5">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <footer>
        <p>&copy; 2026 Jewellery Store. All rights reserved. | Design with <i class="fas fa-heart" style="color:#d4af37;"></i></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
