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
                                <span class="nav-link">Welcome, <strong>{{ Auth::user()->name }}</strong>!</span>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>