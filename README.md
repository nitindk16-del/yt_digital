# YBT Digital

Responsive digital product selling website built with PHP and MySQL.

## Features
- User authentication: signup, login, password reset, profile management
- Product listing, details, cart, checkout, orders, downloads
- Admin dashboard: product, order, user, coupon, and settings management
- Mobile-first design with native-style bottom navigation
- Dark/light mode support

## Setup
1. Copy project to `htdocs/YBT DIGITAL`
2. Create a MySQL database and import `sql/schema.sql`
3. Update database credentials in `includes/config.php`
4. Open the project in browser via `http://localhost/YBT%20DIGITAL/`

## GitHub deployment
This project is built with PHP and MySQL, so it cannot run directly on GitHub Pages. GitHub is still a great place to host the source code and collaborate.

1. Initialize git in the project folder:
   ```bash
   git init
   git add .
   git commit -m "Initial commit: YBT Digital storefront"
   ```
2. Create a new repository on GitHub.
3. Add the GitHub remote and push:
   ```bash
   git remote add origin https://github.com/<your-username>/<your-repo>.git
   git branch -M main
   git push -u origin main
   ```

## Running on a PHP host
To run the site live, deploy it to a PHP-capable host such as Hostinger, A2 Hosting, cPanel/FTP, or a VPS:
- Upload all files except those ignored in `.gitignore`
- Import `sql/schema.sql` into MySQL
- Update `includes/config.php` with production database credentials

If you want automated deploys from GitHub, you can connect the repo to a host that supports PHP deployment or use GitHub Actions with SFTP/FTP deployment.
