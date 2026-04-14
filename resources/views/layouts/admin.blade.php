<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Jewellery Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #e74c3c;
            --light-bg: #ecf0f1;
            --dark-bg: #1a1a1a;
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

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
        }

        .sidebar .brand {
            font-size: 22px;
            font-weight: 700;
            color: white;
            padding: 20px;
            border-bottom: 2px solid var(--accent-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--accent-color);
            color: white;
            padding-left: 25px;
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Dropdown Menu */
        .nav-dropdown {
            color: rgba(255, 255, 255, 0.8);
            padding: 15px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
            transition: all 0.3s;
        }

        .nav-dropdown:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-dropdown i:first-child {
            width: 20px;
            text-align: center;
        }

        .nav-dropdown .dropdown-icon {
            width: 20px;
            text-align: center;
            transition: transform 0.3s;
        }

        .nav-dropdown.active .dropdown-icon {
            transform: rotate(180deg);
        }

        .nav-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .nav-submenu.show {
            max-height: 300px;
        }

        .nav-submenu a {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px 12px 50px;
            margin: 3px 10px;
            border-radius: 6px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .nav-submenu a:hover,
        .nav-submenu a.active {
            background-color: var(--accent-color);
            color: white;
            padding-left: 55px;
        }

        .nav-submenu a i {
            width: 16px;
            text-align: center;
            font-size: 12px;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-info .dropdown-toggle {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Dashboard Cards */
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border-left: 4px solid var(--accent-color);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-card .stat-icon {
            font-size: 40px;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .stat-card .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-card .stat-label {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Table Styling */
        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .table th {
            font-weight: 700;
            border: none;
            padding: 20px;
        }

        .table td {
            padding: 15px 20px;
            vertical-align: middle;
            border-color: #ecf0f1;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Action Buttons */
        .btn-action {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 4px;
            margin: 2px;
            transition: all 0.3s;
        }

        .btn-edit {
            background-color: #3498db;
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background-color: #2980b9;
            color: white;
        }

        .btn-delete {
            background-color: var(--accent-color);
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background-color: #c0392b;
            color: white;
        }

        .btn-view {
            background-color: #27ae60;
            color: white;
            border: none;
        }

        .btn-view:hover {
            background-color: #229954;
            color: white;
        }

        /* Card Header */
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 20px;
            font-weight: 700;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Forms */
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25);
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding-left: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-item.active {
            color: var(--accent-color);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--accent-color);
        }

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }

        .page-link {
            color: var(--primary-color);
            border-color: #ddd;
        }

        .page-link:hover {
            color: white;
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .page-item.active .page-link {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .admin-info {
                width: 100%;
                justify-content: space-between;
            }

            .table {
                font-size: 12px;
            }

            .table th, .table td {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <i class="fas fa-crown"></i> Admin Panel
        </div>
        <nav class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Manage Users
            </a>
            
            <!-- AI Management Dropdown -->
            <div class="nav-dropdown {{ request()->routeIs('admin.ai.*') ? 'active' : '' }}" onclick="toggleAIMenu(this)">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-robot"></i> Manage AI
                </div>
                <i class="fas fa-chevron-down dropdown-icon"></i>
            </div>
            <div class="nav-submenu {{ request()->routeIs('admin.ai.*') ? 'show' : '' }}" id="aiSubmenu">
                <a href="{{ route('admin.ai.credentials') }}" class="nav-submenu-link {{ request()->routeIs('admin.ai.credentials') ? 'active' : '' }}">
                    <i class="fas fa-key"></i> Credentials
                </a>
                <a href="{{ route('admin.ai.agents') }}" class="nav-submenu-link {{ request()->routeIs('admin.ai.agents') ? 'active' : '' }}">
                    <i class="fas fa-cogs"></i> AI Agents
                </a>
            </div>

            <a href="#" class="nav-link">
                <i class="fas fa-chart-bar"></i> Manage Analytics
            </a>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link w-100 text-start" style="border: none; background: none;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>

        <script>
            function toggleAIMenu(element) {
                element.classList.toggle('active');
                const submenu = element.nextElementSibling;
                submenu.classList.toggle('show');
            }
        </script>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <h2><i class="fas fa-tachometer-alt"></i> @yield('page-title', 'Dashboard')</h2>
            <div class="admin-info">
                <span>{{ Auth::guard('admin')->user()->name }}</span>
                <div class="admin-avatar">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</div>
            </div>
        </div>

        <!-- Alerts -->
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

        <!-- Content -->
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
