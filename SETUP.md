# LearnHub LMS - Setup Guide

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0 or higher
- Git

## Installation Steps

### 1. Database Setup

Create the MySQL database:

```sql
CREATE DATABASE learnhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or using MySQL Workbench / phpMyAdmin / command line:

**Windows (PowerShell with MySQL installed):**
```powershell
& "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -p -e "CREATE DATABASE learnhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

**Linux/Mac:**
```bash
mysql -u root -p -e "CREATE DATABASE learnhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 2. Configure Environment

The `.env` file is already configured. Update the following if needed:

```env
DB_DATABASE=learnhub
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

### 3. Run Migrations

```bash
php artisan migrate
```

### 4. Seed Database (Optional - for demo data)

```bash
php artisan db:seed
```

### 5. Install Frontend Dependencies

```bash
npm install
```

### 6. Build Assets

**Development:**
```bash
npm run dev
```

**Production:**
```bash
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

## Default Admin Credentials

After seeding:
- Email: admin@learnhub.com
- Password: password

**IMPORTANT:** Change the password immediately after first login!

## Troubleshooting

### Database Connection Error

1. Ensure MySQL is running
2. Verify database credentials in `.env`
3. Check if `learnhub` database exists
4. Test connection: `php artisan tinker` then `DB::connection()->getPdo();`

### Migration Errors

1. Drop all tables: `php artisan migrate:fresh`
2. Check MySQL user permissions
3. Ensure UTF8MB4 support in MySQL

### Asset Compilation Issues

1. Clear node modules: `rm -rf node_modules` then `npm install`
2. Clear Vite cache: `rm -rf node_modules/.vite`
3. Rebuild: `npm run build`

## Next Steps

1. Create admin user (via seeder or manual registration)
2. Configure payment gateway credentials in `.env`
3. Set up mail server settings
4. Configure file storage (local or S3)
5. Customize site settings via Admin Panel

## Production Deployment

1. Set `APP_ENV=production` and `APP_DEBUG=false`
2. Run `npm run build` for optimized assets
3. Run `php artisan optimize`
4. Configure proper web server (Apache/Nginx)
5. Set up SSL certificate
6. Configure cron for queue workers:
   ```
   * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
   ```

## Support

For issues and questions, please refer to the documentation or contact support.
