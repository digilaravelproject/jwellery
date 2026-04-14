# Jewellery Store - Quick Start Guide

## 🚀 Quick Start (5 minutes)

### 1. Start the Server

```bash
cd c:\xampp\htdocs\jwellery
php artisan serve
```

**Access:** `http://localhost:8000`

---

## 🔗 QUICK NAVIGATION LINKS

### 🏠 Home & Public Pages

- **Home:** http://localhost:8000/
- **User Signup:** http://localhost:8000/signup
- **User Signin:** http://localhost:8000/signin
- **Admin Login:** http://localhost:8000/admin/login

---

## 👤 USER FLOW

### Test User Credentials

```
Email:    test@example.com
Password: password
```

### User Flow Steps:

1. Go to http://localhost:8000/signup
2. Create new account OR
3. Go to http://localhost:8000/signin
4. Login with test credentials
5. View Dashboard at http://localhost:8000/dashboard
6. Click Logout to sign out

---

## 🔐 ADMIN FLOW

### Test Admin Credentials (Choose One)

#### Option 1 - Main Admin

```
Email:    admin@example.com
Password: password
```

#### Option 2 - Manager

```
Email:    manager@example.com
Password: password123
```

### Admin Flow Steps:

1. Go to http://localhost:8000/admin/login
2. Enter admin credentials above
3. View Admin Dashboard at http://localhost:8000/admin/dashboard
4. Navigate menu:
    - **Dashboard** → View statistics
    - **Manage Users** → Full CRUD operations
    - **Manage Analytics** → (Coming soon)
    - **Logout** → Exit admin panel

---

## 👥 USER MANAGEMENT (ADMIN)

### View All Users

**URL:** http://localhost:8000/admin/users
**What you see:**

- List of all users in table format
- Pagination (10 users per page)
- User ID, Name, Email, Status
- Action buttons: View, Edit, Delete

### Create New User

**URL:** http://localhost:8000/admin/users/create
**Fields:**

- Full Name
- Email Address
- Password
- Confirm Password

**Success:** Returns to user list

### View User Details

**URL:** http://localhost:8000/admin/users/{id}
**Where to find:**

- Click "View" button on user list
- Shows: Name, Email, Status, Timestamps, Activity

### Edit User

**URL:** http://localhost:8000/admin/users/{id}/edit
**What you can change:**

- Name
- Email
- Password (optional - leave blank to keep current)
- Click "Update User" to save

### Delete User

**Location:** User list or Edit page
**Confirmation:** Yes/No dialog appears
**Result:** User permanently removed from database

---

## 🎨 DESIGN PREVIEW

### User Side (Signin/Signup/Dashboard)

```
╔════════════════════════════════════════════════════════╗
║  [JEWEL ICON] JEWELLERY    [Nav Items]  [Admin]       ║  ← Navbar
├════════════════════════════════════════════════════════┤
║                                                        ║
║  ┌──────────────────────────────────────────────────┐ ║
║  │  👑 Welcome, Username!                          │ ║
║  │  You have successfully signed in                │ ║
║  └──────────────────────────────────────────────────┘ ║  ← Welcome Header
║                                                        ║
║  ┌─────────────────────┐  ┌─────────────────────────┐ ║
║  │ Account Information │  │    Quick Statistics    │ ║
║  │ Name: ...          │  │  Orders: 0            │ ║
║  │ Email: ...         │  │  Wishlist: 0          │ ║
║  │ Member Since...    │  │                        │ ║
║  │ Status: Active ✓   │  │  [Start Shopping]     │ ║
║  └─────────────────────┘  └─────────────────────────┘ ║
║                                                        ║
║  [Orders] [Wishlist] [Edit Profile] [Settings]        ║  ← Action Cards
║                                                        ║
║  Featured Collections:                                ║
║  [Jewel 1] [Jewel 2] [Jewel 3] [Jewel 4]            ║
│                                                        │
└════════════════════════════════════════════════════════┘
```

### Admin Side (Dashboard/Users)

```
╔═══════════════════════════════════════════════════════════════╗
║ ┌──────────────┬──────────────────────────────────────────┐  ║
║ │ Dashboard    │  Total Users    | Total Orders          │  ║
║ │ [×] Users    │  ┌──────────┐  ┌──────────┐            │  ║
║ │ [×] Analytics│  │    45    │  │    0     │            │  ║
║ │ [×] Logout   │  └──────────┘  └──────────┘            │  ║
║ └──────────────┴──────────────────────────────────────────┘  ║
║                                                               ║
║  ┌────────────────────────────────────────────────────────┐  ║
║  │ Users Table                                            │  ║
║  ├─────┬─────────┬──────────────────┬──────────────────┤  ║
║  │ ID  │ Name    │ Email            │ Actions (...)   │  ║
║  ├─────┼─────────┼──────────────────┼──────────────────┤  ║
║  │ 1   │ User 1  │ user1@email.com  │ [VIEW] [EDIT] [X]│  ║
║  │ 2   │ User 2  │ user2@email.com  │ [VIEW] [EDIT] [X]│  ║
║  │ 3   │ User 3  │ user3@email.com  │ [VIEW] [EDIT] [X]│  ║
║  ├─────┴─────────┴──────────────────┴──────────────────┤  ║
║  │ Pagination: [< 1 2 3 >]                            │  ║
║  └────────────────────────────────────────────────────┘  ║
║                                                               ║
└═══════════════════════════════════════════════════════════════┘
```

---

## 📋 TROUBLESHOOTING QUICK FIXES

### Problem: "SQLSTATE[HY000]: General error"

**Solution:**

```bash
php artisan migrate:fresh --seed
```

### Problem: "Route not found"

**Solution:**

```bash
php artisan route:cache
php artisan route:clear
```

### Problem: "View not found"

**Solution:**

```bash
php artisan view:clear
```

### Problem: Login not working

**Check:**

1. Database is connected
2. Credentials are correct
3. Check `config/auth.php` guards
4. Try admin vs user login separately

### Problem: CSS/Styling not showing

**Solution:**

- Hard refresh browser: `Ctrl + Shift + Delete`
- Clear Laravel cache: `php artisan cache:clear`

---

## 🔄 DATABASE OPERATIONS

### Reset Everything (Start Fresh)

```bash
php artisan migrate:fresh --seed
```

### Reset Without Seeding

```bash
php artisan migrate:fresh
```

### Seed Only (Keep existing data)

```bash
php artisan db:seed
```

### Seed Specific Seeder

```bash
php artisan db:seed --class=AdminSeeder
```

---

## 📊 USER STATISTICS (From Dashboard)

### Total Users Count

- Displayed on Admin Dashboard
- Updated in real-time
- Shows in stats card

### View User Details

- Click any user to see:
    - Full profile information
    - Account creation date
    - Last updated timestamp
    - Account status
    - Activity info

---

## 🔐 SECURITY REMINDERS

### Password Security

- ✅ All passwords are hashed (bcrypt)
- ✅ Never stored in plain text
- ✅ Minimum 6 characters
- ✅ Confirmation required on signup

### Session Security

- ✅ Session tokens generated
- ✅ CSRF protection on all forms
- ✅ Automatic timeout
- ✅ Secure logout clears session

### Admin Protection

- ✅ Separate admin guard
- ✅ Admin routes middleware protected
- ✅ Different authentication from users
- ✅ Session isolation per guard

---

## 📱 RESPONSIVE FEATURES

### Mobile View (< 768px)

- Sidebar collapses
- Navigation menu becomes hamburger
- Single column layout
- Touch-friendly buttons

### Tablet View (768px - 1024px)

- Adjusted spacing
- Responsive tables
- Sidebar visible
- Optimized cards

### Desktop View (> 1024px)

- Full sidebar
- Multi-column layouts
- Expanded tables
- Complete navigation

---

## 💡 USEFUL COMMANDS

```bash
# Start dev server
php artisan serve

# Generate fresh API token
php artisan tinker
>>> Auth::user()->createToken('token-name')

# Check what's in database
php artisan tinker
>>> App\Models\User::all()
>>> App\Models\Admin::all()

# Make a specific migration
php artisan make:migration create_new_table

# Create controller
php artisan make:controller NewController

# View all routes
php artisan route:list

# Clear all caches
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:clear
```

---

## 📚 HELPFUL RESOURCES

- **Laravel Docs:** https://laravel.com/docs
- **Blade Templates:** https://laravel.com/docs/blade
- **Authentication:** https://laravel.com/docs/authentication
- **Bootstrap 5:** https://getbootstrap.com/docs
- **Font Awesome:** https://fontawesome.com/docs

---

## ✨ FEATURES AT A GLANCE

| Feature         | User     | Admin    |
| --------------- | -------- | -------- |
| Signup/Login    | ✅       | ✅       |
| Dashboard       | ✅       | ✅       |
| Profile View    | ✅       | ✅       |
| Profile Edit    | ✓ Future | ✅       |
| User Management | ✗        | ✅       |
| Analytics       | ✓ Future | ✓ Future |
| Logout          | ✅       | ✅       |

---

## 🎯 WHAT'S NEXT?

After exploring the system:

1. **Customize** - Change colors, fonts, layouts
2. **Expand** - Add more features (reviews, products)
3. **Deploy** - Move to live server
4. **Integrate** - Add payment gateway
5. **Scale** - Add caching, optimization

---

## 📞 QUICK REFERENCE

| Action          | URL                    | Method |
| --------------- | ---------------------- | ------ |
| Home            | /                      | GET    |
| Signup Page     | /signup                | GET    |
| Register User   | /signup                | POST   |
| Login Page      | /signin                | GET    |
| Login User      | /signin                | POST   |
| Dashboard       | /dashboard             | GET    |
| Logout          | /logout                | POST   |
| Admin Login     | /admin/login           | GET    |
| Admin Process   | /admin/login           | POST   |
| Admin Dashboard | /admin/dashboard       | GET    |
| View Users      | /admin/users           | GET    |
| Create User     | /admin/users/create    | GET    |
| Store User      | /admin/users           | POST   |
| View User       | /admin/users/{id}      | GET    |
| Edit User       | /admin/users/{id}/edit | GET    |
| Update User     | /admin/users/{id}      | PUT    |
| Delete User     | /admin/users/{id}      | DELETE |
| Admin Logout    | /admin/logout          | POST   |

---

## ✅ YOU'RE ALL SET!

The system is ready to use. Happy exploring! 🎉

**Start with:** http://localhost:8000 → Click "Sign Up" or "Sign In"

For any issues, check **SETUP_GUIDE.md** for detailed instructions.
