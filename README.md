# Cesizen

A modern full-stack web application built with Laravel 12, Vue 3, Inertia.js, and Nuxt UI components.

## 🚀 Tech Stack

### Backend
- **Laravel 12** - PHP web application framework
- **Laravel Fortify** - Authentication backend (2FA support)
- **Laravel Horizon** - Queue monitoring dashboard
- **Laravel Wayfinder** - Type-safe routing for frontend
- **MySQL** - Database

### Frontend
- **Vue 3** - Progressive JavaScript framework
- **Inertia.js v2** - Modern monolith architecture (no API needed)
- **TypeScript** - Type-safe JavaScript
- **Nuxt UI** - Beautiful Vue components
- **Tailwind CSS v4** - Utility-first CSS framework
- **Vite** - Fast build tool with HMR

### Development Tools
- **Pest** - Testing framework
- **PHPStan (Larastan)** - Static analysis
- **Pint** - Code style fixer
- **Rector** - Automated refactoring
- **ESLint** - JavaScript linter
- **Prettier** - Code formatter

## 📋 Prerequisites

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **npm** >= 9.x
- **MySQL** >= 8.0 (or MariaDB)

## 🛠️ Installation

### 1. Clone the repository

```bash
git clone <repository-url> cesizen
cd cesizen
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install JavaScript dependencies

```bash
npm install
```

### 4. Environment setup

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure database

Edit your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cesizen
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Build frontend assets (optional for dev)

```bash
npm run build
```

## 🎯 Quick Start

### Development Mode

You need **two terminal windows** running simultaneously:

#### Terminal 1: Start the Laravel backend

```bash
php artisan serve
```

The backend will be available at `http://127.0.0.1:8000`

Or run on a specific port:

```bash
php artisan serve --port=3000
```

#### Terminal 2: Start the Vite dev server

```bash
npm run dev
```

Vite runs on `http://localhost:5173` for hot module replacement (HMR).

### Access the application

Open your browser and navigate to the Laravel server URL (e.g., `http://127.0.0.1:8000` or `http://127.0.0.1:3000`).

> **Note:** Always access the app through the Laravel server, not the Vite dev server directly.

## 📦 Available Scripts

### Backend (PHP)

```bash
# Run Laravel development server
php artisan serve

# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Run tests
php artisan test

# Code style fixing
./vendor/bin/pint

# Static analysis
./vendor/bin/phpstan analyse

# Queue monitoring (Horizon)
php artisan horizon
```

### Frontend (JavaScript)

```bash
# Development server with HMR
npm run dev

# Build for production
npm run build

# Build with SSR support
npm run build:ssr

# Lint and fix code
npm run lint

# Format code
npm run format

# Check formatting
npm run format:check
```

## 🏗️ Project Structure

```
cesizen/
├── app/                    # Laravel application code
│   ├── Http/
│   │   ├── Controllers/   # Controllers
│   │   ├── Middleware/    # Middleware
│   │   └── Requests/      # Form requests
│   └── Models/            # Eloquent models
├── config/                # Configuration files
├── database/
│   ├── migrations/        # Database migrations
│   ├── factories/         # Model factories
│   └── seeders/          # Database seeders
├── resources/
│   ├── css/              # Stylesheets
│   ├── js/
│   │   ├── components/   # Vue components
│   │   ├── layouts/      # Layout components
│   │   ├── pages/        # Inertia pages
│   │   ├── routes/       # Type-safe routes
│   │   └── app.ts        # Frontend entry point
│   └── views/            # Blade templates
├── routes/
│   ├── web.php           # Web routes
│   ├── auth.php          # Authentication routes
│   └── settings.php      # Settings routes
├── tests/                # Pest tests
├── .env                  # Environment configuration
├── composer.json         # PHP dependencies
├── package.json          # JavaScript dependencies
└── vite.config.ts        # Vite configuration
```

## 🔐 Authentication Features

This project includes a complete authentication system powered by Laravel Fortify:

- ✅ User Registration
- ✅ Login / Logout
- ✅ Password Reset
- ✅ Email Verification
- ✅ Two-Factor Authentication (2FA)
- ✅ Profile Management
- ✅ Security Settings

### Available Auth Pages

- `/register` - User registration
- `/login` - User login
- `/forgot-password` - Request password reset
- `/verify-email` - Email verification
- `/dashboard` - User dashboard (requires auth)

## 🎨 Key Features

### Type-Safe Routing

Thanks to Laravel Wayfinder, all routes are type-safe and auto-imported in Vue components:

```vue
<script setup lang="ts">
import { dashboard, login, register } from '@/routes'
</script>

<template>
  <Link :href="dashboard()">Dashboard</Link>
</template>
```

### Nuxt UI Components

Pre-configured with Nuxt UI for beautiful, accessible components:

```vue
<UButton>Click me</UButton>
<UCard>Content</UCard>
<UInput v-model="value" />
```

### Inertia.js

No API needed - share data directly from controllers to Vue components:

```php
// Controller
return Inertia::render('Dashboard', [
    'user' => Auth::user(),
]);
```

```vue
// Component
<script setup lang="ts">
defineProps<{ user: User }>()
</script>
```

## 🚀 Production Deployment

### 1. Build assets

```bash
npm run build
```

### 2. Optimize Laravel

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### 3. Set production environment

```env
APP_ENV=production
APP_DEBUG=false
```

### 4. Run migrations

```bash
php artisan migrate --force
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter=ExampleTest
```

## 🔧 Configuration

### Update Dependencies

```bash
composer run update:requirements
```

This will update both Composer and npm dependencies to their latest versions.

### Queue Configuration

Configure your queue driver in `.env`:

```env
QUEUE_CONNECTION=database
```

Run the queue worker:

```bash
php artisan queue:work
```

Or use Horizon for monitoring:

```bash
php artisan horizon
```

## 📝 Environment Variables

Key environment variables:

```env
APP_NAME=Cesizen
APP_ENV=local
APP_URL=http://127.0.0.1:3000

DB_CONNECTION=mysql
DB_DATABASE=cesizen

SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced under the MIT license.

## 🐛 Troubleshooting

### Vite connection errors

If you see errors about Vite not connecting:

1. Ensure both `php artisan serve` and `npm run dev` are running
2. Access the app through the Laravel URL, not the Vite URL
3. Check that `APP_URL` in `.env` matches your Laravel server URL

### Database connection issues

```bash
# Check your database credentials in .env
# Ensure MySQL is running
# Test connection:
php artisan migrate:status
```

### Permission issues

```bash
chmod -R 775 storage bootstrap/cache
```

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Nuxt UI Documentation](https://ui.nuxt.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)

---

Built with ❤️ using Laravel & Vue
