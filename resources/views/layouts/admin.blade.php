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
            --primary-yellow: #FFD966;
            --primary-color: #2D2D2D;
            --secondary-color: #F5F5F5;
            --accent-color: #FFD966;
            --light-bg: #F9F7F2;
            --dark-bg: #1a1a1a;
            --text-main: #2D2D2D;
            --text-secondary: #666;
            --border-light: #E0E0E0;
            --shadow-lg: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
            background: linear-gradient(135deg, #F9F7F2 0%, #E8E2D6 100%);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #3d3d3d 100%);
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.15);
            overflow-y: auto;
        }

        .sidebar .brand {
            font-size: 22px;
            font-weight: 700;
            color: white;
            padding: 20px;
            border-bottom: 2px solid var(--primary-yellow);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            background-color: var(--primary-yellow);
            color: var(--text-main);
            padding-left: 25px;
            font-weight: 600;
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
            background-color: var(--primary-yellow);
            color: var(--text-main);
            padding-left: 55px;
            font-weight: 600;
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
            padding: 25px 30px;
            border-radius: 30px;
            box-shadow: var(--shadow-lg);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .top-bar h2 {
            color: var(--primary-yellow);
            font-weight: 700;
            margin: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-info .dropdown-toggle {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-yellow) 0%, #f2cc5b 100%);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Dashboard Cards */
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 25px;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s;
            border-left: 4px solid var(--primary-yellow);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .stat-card .stat-icon {
            font-size: 40px;
            color: var(--primary-yellow);
            margin-bottom: 10px;
        }

        .stat-card .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-main);
        }

        .stat-card .stat-label {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Table Styling */
        .table {
            background: white;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .table thead {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, #f2cc5b 100%);
            color: var(--text-main);
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

        /* Pagination spacing after table */
        .table-responsive + nav[aria-label="Page navigation"] {
            margin-top: 30px !important;
        }

        .card-body nav[aria-label="Page navigation"] {
            margin-top: 25px !important;
        }

        /* Ensure action column buttons fit in one row */
        .table td:last-child {
            min-width: 200px;
            padding: 15px 10px !important;
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
            border-radius: 15px;
            padding: 8px 12px;
            font-size: 14px;
            white-space: nowrap;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-edit:hover {
            background-color: #2980b9;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 8px 12px;
            font-size: 14px;
            white-space: nowrap;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c82333;
            color: white;
        }

        .btn-view {
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 8px 12px;
            font-size: 14px;
            white-space: nowrap;
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            background-color: #229954;
            color: white;
        }

        /* Card Header */
        .card-header {
            background: linear-gradient(135deg, var(--primary-yellow) 0%, #f2cc5b 100%);
            color: var(--text-main);
            border: none;
            padding: 20px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .card {
            border: none;
            border-radius: 25px;
            box-shadow: var(--shadow-lg);
            margin-bottom: 20px;
            background: white;
        }

        /* Forms */
        .form-label {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: block;
        }

        .form-control {
            border-radius: 20px;
            border: 2px solid #ddd;
            padding: 12px 18px;
            transition: all 0.3s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: white;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-yellow);
            box-shadow: 0 0 0 0.2rem rgba(255, 217, 102, 0.3);
            background-color: white;
        }

        .card-body {
            padding: 30px;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding-left: 0;
            margin-bottom: 20px;
        }

        .breadcrumb-item.active {
            color: var(--primary-yellow);
            font-weight: 600;
        }

        .breadcrumb-item a {
            color: var(--text-main);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-yellow);
        }

        /* Pagination - Complete Override */
        nav[aria-label="Page navigation"] {
            text-align: center;
            margin-top: 30px !important;
            padding: 20px 0 !important;
            width: 100%;
            display: block !important;
        }

        nav[aria-label="Page navigation"] .pagination {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 8px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            list-style: none !important;
            flex-wrap: wrap !important;
            width: fit-content !important;
        }

        nav[aria-label="Page navigation"] .page-item {
            display: inline-block !important;
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        /* Override Bootstrap page-link */
        nav[aria-label="Page navigation"] .page-link,
        nav[aria-label="Page navigation"] a.page-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: auto !important;
            min-width: 40px !important;
            min-height: 40px !important;
            padding: 8px 12px !important;
            margin: 0 !important;
            border: 2px solid #ddd !important;
            border-radius: 15px !important;
            background-color: white !important;
            color: var(--text-main) !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: all 0.3s ease !important;
            line-height: 1 !important;
            position: relative !important;
        }

        nav[aria-label="Page navigation"] .page-link:hover,
        nav[aria-label="Page navigation"] a.page-link:hover {
            background-color: var(--primary-yellow) !important;
            border-color: var(--primary-yellow) !important;
            color: var(--text-main) !important;
            transform: translateY(-2px) !important;
            text-decoration: none !important;
        }

        nav[aria-label="Page navigation"] .page-item.active .page-link,
        nav[aria-label="Page navigation"] .page-item.active a.page-link {
            background-color: var(--primary-yellow) !important;
            border-color: var(--primary-yellow) !important;
            color: var(--text-main) !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(255, 217, 102, 0.3) !important;
            cursor: default !important;
            pointer-events: none !important;
        }

        nav[aria-label="Page navigation"] .page-item.disabled .page-link,
        nav[aria-label="Page navigation"] .page-item.disabled a.page-link {
            background-color: #f5f5f5 !important;
            border-color: #e0e0e0 !important;
            color: #999 !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            pointer-events: none !important;
        }

        nav[aria-label="Page navigation"] .page-link:focus,
        nav[aria-label="Page navigation"] a.page-link:focus {
            outline: none !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 217, 102, 0.25) !important;
        }

        nav[aria-label="Page navigation"] span.page-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 40px !important;
            min-height: 40px !important;
            padding: 8px 12px !important;
            margin: 0 !important;
            border: 2px solid #ddd !important;
            border-radius: 15px !important;
            background-color: white !important;
            color: var(--text-main) !important;
            font-weight: 500 !important;
            font-size: 14px !important;
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

            td:last-child {
                flex-wrap: wrap;
                gap: 6px;
            }

            .btn-view, .btn-edit, .btn-delete {
                padding: 6px 10px;
                font-size: 12px;
            }

            .pagination {
                font-size: 13px;
                gap: 4px;
                margin: 0 !important;
                padding: 0 !important;
            }

            nav[aria-label="Page navigation"] .page-link {
                padding: 6px 10px !important;
                min-width: 36px !important;
                min-height: 36px !important;
                font-size: 12px !important;
            }

            nav[aria-label="Page navigation"] {
                margin-top: 20px !important;
                padding: 15px 0 !important;
            }

            nav[aria-label="Page navigation"] .pagination {
                gap: 4px !important;
            }

            .card-body {
                padding: 20px;
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
                <a href="{{ route('admin.ai.prompts') }}" class="nav-submenu-link {{ request()->routeIs('admin.ai.prompts') ? 'active' : '' }}">
                    <i class="fas fa-comment-dots"></i> Manage Prompts
                </a>
            </div>

            <a href="{{ route('admin.analytics.index') }}" class="nav-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Manage Analytics
            </a>
            <a href="{{ route('admin.selections.index') }}" class="nav-link {{ request()->routeIs('admin.selections.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group"></i> Manage Selection
            </a>            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
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
            <div class="admin-info" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#editAdminProfileModal">
                <span style="cursor: pointer;">{{ Auth::guard('admin')->user()->name }}</span>
                <div class="admin-avatar" style="cursor: pointer;">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</div>
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

    <!-- Edit Admin Profile Modal -->
    <div class="modal fade" id="editAdminProfileModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); border: none;">
                    <h5 class="modal-title" style="color: white; font-weight: 700;">
                        <i class="fas fa-user-shield"></i> Edit Admin Profile
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editAdminProfileForm" onsubmit="submitAdminProfileForm(event)">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-success" id="adminProfileMessage" style="display: none;"></div>
                        <div class="alert alert-danger" id="adminProfileError" style="display: none;"></div>

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="admin_profile_name" class="form-label">
                                <i class="fas fa-user-shield"></i> Full Name
                            </label>
                            <input type="text" class="form-control" id="admin_profile_name" name="name" required placeholder="Enter your full name">
                            <small class="form-text text-muted">Your display name in the admin panel</small>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="admin_profile_email" class="form-label">
                                <i class="fas fa-envelope"></i> Email Address
                            </label>
                            <input type="email" class="form-control" id="admin_profile_email" name="email" required placeholder="Enter your email">
                            <small class="form-text text-muted">Your admin account email</small>
                        </div>

                        <!-- Password Section -->
                        <hr>
                        <h6 class="mb-3"><i class="fas fa-lock"></i> Change Password (Optional)</h6>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="admin_current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="admin_current_password" name="current_password" placeholder="Enter your current password">
                            <small class="form-text text-muted">Required only if you're changing your password</small>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="admin_new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="admin_new_password" name="password" placeholder="Leave empty to keep current password">
                            <small class="form-text text-muted">Minimum 6 characters</small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="admin_confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="admin_confirm_password" name="password_confirmation" placeholder="Confirm your new password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white; border-radius: 20px; font-weight: 600; padding: 10px 25px;">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Load admin profile data when modal is shown
        const editAdminProfileModal = document.getElementById('editAdminProfileModal');
        if (editAdminProfileModal) {
            editAdminProfileModal.addEventListener('show.bs.modal', function() {
                axios.get('{{ route("admin.profile.edit") }}')
                    .then(response => {
                        document.getElementById('admin_profile_name').value = response.data.admin.name;
                        document.getElementById('admin_profile_email').value = response.data.admin.email;
                    })
                    .catch(error => {
                        console.error('Error loading admin profile:', error);
                    });
            });
        }

        function submitAdminProfileForm(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('editAdminProfileForm'));

            axios.post('{{ route("admin.profile.update") }}', formData)
                .then(response => {
                    if (response.data.success) {
                        document.getElementById('adminProfileMessage').style.display = 'block';
                        document.getElementById('adminProfileMessage').innerHTML = '<i class="fas fa-check-circle"></i> ' + response.data.message;
                        document.getElementById('adminProfileError').style.display = 'none';
                        
                        // Reset form
                        document.getElementById('editAdminProfileForm').reset();
                        
                        // Reload page after 1.5 seconds to show updated name
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    document.getElementById('adminProfileError').style.display = 'block';
                    if (error.response && error.response.data && error.response.data.message) {
                        document.getElementById('adminProfileError').innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + error.response.data.message;
                    } else if (error.response && error.response.data && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        let errorText = '<i class="fas fa-exclamation-circle"></i> ';
                        for (let field in errors) {
                            errorText += errors[field][0] + '<br>';
                        }
                        document.getElementById('adminProfileError').innerHTML = errorText;
                    } else {
                        document.getElementById('adminProfileError').innerHTML = '<i class="fas fa-exclamation-circle"></i> Error updating profile. Please try again.';
                    }
                });
        }
    </script>
</body>
</html>
