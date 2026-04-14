# Jewellery Store - Complete Authentication & Admin System

A comprehensive Laravel-based jewellery e-commerce platform with complete user authentication, admin panel, and user management system.

## 📋 System Features

### User Features

- ✅ User Registration/Signup with validation
- ✅ User Login/Signin with session management
- ✅ User Dashboard with welcome message
- ✅ Logout functionality
- ✅ Responsive design with attractive UI
- ✅ Form validation & error handling
- ✅ Session management

### Admin Features

- ✅ Separate Admin Authentication (Guard)
- ✅ Admin Dashboard with statistics
- ✅ Complete User Management Module
- ✅ CRUD Operations on Users (Create, Read, Update, Delete)
- ✅ User listing with pagination
- ✅ View user details
- ✅ Edit user information
- ✅ Delete user accounts
- ✅ Admin sidebar navigation
- ✅ Responsive admin dashboard

### Design Features

- 🎨 Professional and attractive UI
- 🎨 Different design for User and Admin sides
- 🎨 Dark navbar with golden accents
- 🎨 Admin dashboard with dark theme
- 🎨 Smooth animations and transitions
- 🎨 Mobile-responsive layouts
- 🎨 Bootstrap 5 integration
- 🎨 Font Awesome icons

## 🚀 Getting Started

### Prerequisites

- PHP 8.0 or higher
- Composer
- Laravel 11.x
- MySQL/MariaDB database
- XAMPP (or similar local server)

### Installation Steps

1. **Navigate to the project directory**

    ```bash
    cd c:\xampp\htdocs\jwellery
    cp .env.example .env
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Generate application key**

    ```bash
    php artisan key:generate
    ```

4. **Configure database in .env**

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=jewellery
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Run migrations**

    ```bash
    php artisan migrate
    ```

6. **Seed test data**

    ```bash
    php artisan db:seed
    ```

7. **Start the development server**
    ```bash
    php artisan serve
    ```

Visit `http://localhost:8000` in your browser.

## 👤 Test Credentials

### User Test Account

- **Email:** test@example.com
- **Password:** password

### Admin Test Accounts

1. **Email:** admin@example.com
   **Password:** password

2. **Email:** manager@example.com
   **Password:** password123

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php           # User authentication
│   │   ├── AdminAuthController.php      # Admin authentication
│   │   └── AdminUserController.php      # User management CRUD
│   └── Middleware/
│       ├── EnsureUserIsAuthenticated.php
│       └── EnsureAdminIsAuthenticated.php
├── Models/
│   ├── User.php
│   └── Admin.php

config/
└── auth.php                             # Authentication configuration

database/
├── migrations/
│   ├── *_create_users_table.php
│   ├── *_create_admins_table.php
│   ├── *_create_cache_table.php
│   └── *_create_jobs_table.php
└── seeders/
    ├── AdminSeeder.php
    └── DatabaseSeeder.php

resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php                # User layout
    │   └── admin.blade.php              # Admin layout
    ├── auth/
    │   ├── signup.blade.php
    │   └── signin.blade.php
    ├── user/
    │   └── dashboard.blade.php
    ├── admin/
    │   ├── login.blade.php
    │   ├── dashboard.blade.php
    │   └── users/
    │       ├── index.blade.php
    │       ├── create.blade.php
    │       ├── edit.blade.php
    │       └── show.blade.php
    └── welcome.blade.php

routes/
└── web.php                              # All routes defined

```

## 🛣️ Application Routes

### Public Routes

- `/` - Home page
- `/signup` - User registration page
- `/signin` - User login page
- `/admin/login` - Admin login page

### User Routes (Protected)

- `/dashboard` - User dashboard
- `/logout` - Logout (POST)

### Admin Routes (Protected)

- `/admin/dashboard` - Admin dashboard
- `/admin/users` - Users list
- `/admin/users/create` - Create new user
- `/admin/users/{id}` - View user details
- `/admin/users/{id}/edit` - Edit user
- `/admin/users/{id}` - Delete user (DELETE route via form)
- `/admin/logout` - Admin logout (POST)

## 🔐 Authentication System

### Guards Configuration

The application uses two separate authentication guards:

- **`web` (Default):** For user authentication
- **`admin`:** For admin authentication

Located in `config/auth.php`

### Middleware Protection

- Request requires login: Use `Auth::check()`
- Admin-only resources: Use `Auth::guard('admin')->check()`

## 📝 User Management CRUD

### Create User

- Navigate to: `/admin/users/create`
- Fill in: Name, Email, Password
- Submit form

### Read Users

- Navigate to: `/admin/users`
- View all users paginated (10 per page)
- Click "View" to see full details

### Update User

- Navigate to: `/admin/users`
- Click "Edit" button
- Modify information
- Optional password change
- Submit to update

### Delete User

- Navigate to: `/admin/users` or `/admin/users/{id}`
- Click "Delete" button
- Confirm deletion

## 🎨 Design Highlights

### User Side Design

- **Color Scheme:** Golden (#d4af37) + Dark gray (#1a1a1a)
- **Navbar:** Dark background with golden jewellery brand
- **Cards:** White with shadow effects
- **Buttons:** Golden with hover animations
- **Typography:** Modern Poppins font

### Admin Side Design

- **Color Scheme:** Dark blue (#2c3e50) + Red accent (#e74c3c)
- **Sidebar:** Fixed navigation with active indicators
- **Statistics Cards:** Icon-based with color coding
- **Tables:** Dark headers with hover effects
- **Responsive:** Collapses to mobile-friendly layout

## 🔧 Customization

### Change Colors

Edit the CSS variables in:

- `resources/views/layouts/app.blade.php` (User design)
- `resources/views/layouts/admin.blade.php` (Admin design)

### Custom Validation Rules

Edit validation in controllers:

- `app/Http/Controllers/AuthController.php`
- `app/Http/Controllers/AdminUserController.php`

### Modify Database Fields

1. Create new migration: `php artisan make:migration`
2. Update models
3. Run: `php artisan migrate`

## 📱 Responsive Design

- Fully responsive on mobile devices
- Tablet optimized layout
- Desktop-first design approach
- Breakpoints at 768px and 1024px

## 🛡️ Security Features

- Password hashing using Laravel's Hash facade
- CSRF protection on all forms
- SQL injection prevention via Eloquent ORM
- Session management
- Separate admin and user authentication

## 📊 Database Schema

### Users Table

- id (Primary Key)
- name (String)
- email (String, Unique)
- email_verified_at (Timestamp, Nullable)
- password (String, Hashed)
- remember_token (String, Nullable)
- created_at (Timestamp)
- updated_at (Timestamp)

### Admins Table

- id (Primary Key)
- name (String)
- email (String, Unique)
- password (String, Hashed)
- remember_token (String, Nullable)
- created_at (Timestamp)
- updated_at (Timestamp)

## 🐛 Common Issues & Solutions

### Database Connection Error

- Ensure MySQL is running
- Check `.env` database credentials
- Run: `php artisan migrate:fresh --seed`

### 404 Routes Not Found

- Ensure routes are in `routes/web.php`
- Clear cache: `php artisan route:cache` (development only)

### View Not Found

- Check blade syntax in views
- Ensure views are in `resources/views/` directory
- Clear view cache: `php artisan view:clear`

### Seeding Issues

- Delete test data: `php artisan migrate:fresh`
- Re-seed: `php artisan db:seed`

## 🚦 Next Steps

1. **Add Email Verification**
    - Use Laravel's built-in email verification

2. **Implement Password Reset**
    - Create forgot password functionality

3. **Add User Profile Edit**
    - Allow users to update their own profile

4. **Create Analytics Module**
    - Add charts and graphs to admin dashboard

5. **Implement Product Management**
    - Add jewellery products catalog

6. **Shopping Cart & Orders**
    - E-commerce functionality

## 📞 Support & Help

For issues or enhancements:

1. Check Laravel documentation: https://laravel.com/docs
2. Review code comments in controllers
3. Test with provided test accounts

## 📄 License

This project is open source and available under the MIT License.

---

## 🎯 Summary

This complete authentication and admin system provides:

- ✅ Full user signup/signin flow
- ✅ Separate admin authentication
- ✅ Professional UI/UX design
- ✅ Complete CRUD for user management
- ✅ Mobile-responsive layouts
- ✅ Security best practices
- ✅ Test data included
- ✅ Ready for production with minimal setup

**Happy coding! 🚀**
