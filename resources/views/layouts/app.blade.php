<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jewellery Store')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-yellow: #FFD966;
            --soft-bg: #F9F7F2;
            --text-main: #2D2D2D;
            --primary-gold: #d4af37;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0808081a; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .main-auth-container {
            width: 100%;
            max-width: 1100px;
            background: linear-gradient(135deg, #F9F7F2 0%, #E8E2D6 100%);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column; /* Stack navbar and content */
            min-height: 750px;
            position: relative;
        }

        /* Custom Navbar Styling */
        .custom-navbar {
            padding: 20px 40px;
            background: transparent;
        }

        .custom-navbar .navbar-brand {
            font-weight: 700;
            color: var(--text-main) !important;
            font-size: 1.5rem;
        }

        .custom-navbar .nav-link {
            color: var(--text-main) !important;
            font-weight: 500;
            margin-left: 15px;
            transition: color 0.3s;
        }

        .custom-navbar .nav-link:hover {
            color: var(--primary-gold) !important;
        }

        /* Logic for alerts */
        .alert-container {
            position: absolute;
            top: 80px; /* Adjusted to sit below navbar */
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 90%;
        }

        .btn-primary-custom {
            background-color: var(--primary-yellow);
            border: none;
            color: #333;
            font-weight: 600;
            border-radius: 50px;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #f2cc5b;
            transform: translateY(-2px);
        }

        .content-area {
            flex-grow: 1;
            display: flex;
        }

        /* Adjustments for the Auth layout wrapper */
        .auth-layout .navbar { display: none; }
    </style>
</head>
<body class="{{ !Auth::check() ? 'auth-layout' : '' }}">

    <div class="main-auth-container">
        
        @auth
            <nav class="navbar navbar-expand-lg custom-navbar">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">
                        <i class="fas fa-gem text-warning"></i> Jewellery
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto align-items-center">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link text-muted">|</span>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="text-decoration: none; cursor: pointer;">
                                    Welcome, <strong style="color: var(--primary-gold);">{{ Auth::user()->name }}</strong>!
                                    <i class="fas fa-user-edit ms-1" style="font-size: 0.9rem;"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="ms-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        Logout <i class="fas fa-sign-out-alt ms-1"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endauth

        @if(session('success') || session('error') || $errors->any())
            <div class="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach($errors->all() as $error) <span>{{ $error }}</span> @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        @endif

        <div class="content-area">
            @yield('content')
        </div>

        <!-- Edit Profile Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #FFD966 0%, #f2cc5b 100%); border: none;">
                        <h5 class="modal-title" style="color: #2D2D2D; font-weight: 700;">
                            <i class="fas fa-user-edit"></i> Edit Your Profile
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="editProfileForm" onsubmit="submitProfileForm(event)">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-info" id="profileMessage" style="display: none;"></div>
                            <div class="alert alert-danger" id="profileError" style="display: none;"></div>

                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="profile_name" class="form-label">
                                    <i class="fas fa-user"></i> Full Name
                                </label>
                                <input type="text" class="form-control" id="profile_name" name="name" required placeholder="Enter your full name">
                                <small class="form-text text-muted">Your display name across the platform</small>
                            </div>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="profile_email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input type="email" class="form-control" id="profile_email" name="email" required placeholder="Enter your email">
                                <small class="form-text text-muted">We'll use this to contact you</small>
                            </div>

                            <!-- Password Section -->
                            <hr>
                            <h6 class="mb-3"><i class="fas fa-lock"></i> Change Password (Optional)</h6>

                            <!-- Current Password -->
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter your current password">
                                <small class="form-text text-muted">Required only if you're changing your password</small>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="password" placeholder="Leave empty to keep current password">
                                <small class="form-text text-muted">Minimum 6 characters</small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="password_confirmation" placeholder="Confirm your new password">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Load profile data when modal is shown
        const editProfileModal = document.getElementById('editProfileModal');
        if (editProfileModal) {
            editProfileModal.addEventListener('show.bs.modal', function() {
                axios.get('{{ route("profile.edit") }}')
                    .then(response => {
                        document.getElementById('profile_name').value = response.data.user.name;
                        document.getElementById('profile_email').value = response.data.user.email;
                    })
                    .catch(error => {
                        console.error('Error loading profile:', error);
                    });
            });
        }

        function submitProfileForm(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('editProfileForm'));

            axios.post('{{ route("profile.update") }}', formData)
                .then(response => {
                    if (response.data.success) {
                        document.getElementById('profileMessage').style.display = 'block';
                        document.getElementById('profileMessage').innerHTML = '<i class="fas fa-check-circle"></i> ' + response.data.message;
                        document.getElementById('profileError').style.display = 'none';
                        
                        // Reset form
                        document.getElementById('editProfileForm').reset();
                        
                        // Reload page after 1.5 seconds to show updated name
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    document.getElementById('profileError').style.display = 'block';
                    if (error.response && error.response.data && error.response.data.message) {
                        document.getElementById('profileError').innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + error.response.data.message;
                    } else if (error.response && error.response.data && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        let errorText = '<i class="fas fa-exclamation-circle"></i> ';
                        for (let field in errors) {
                            errorText += errors[field][0] + '<br>';
                        }
                        document.getElementById('profileError').innerHTML = errorText;
                    } else {
                        document.getElementById('profileError').innerHTML = '<i class="fas fa-exclamation-circle"></i> Error updating profile. Please try again.';
                    }
                });
        }
    </script>
</body>
</html>