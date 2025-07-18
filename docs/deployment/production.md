# Production Deployment Guide

## Prerequisites
- Production server with SSH access
- Domain name (optional but recommended)
- SSL certificate (Let's Encrypt recommended)
- Database server (MySQL/MariaDB)
- PHP 8.1+ with required extensions
- Composer
- Node.js & NPM
- Git

## Server Setup

### 1. Server Requirements
- Ubuntu 20.04 LTS / 22.04 LTS (recommended)
- 2GB RAM minimum (4GB recommended)
- 20GB free disk space

### 2. Install Required Software
```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y nginx mysql-server php8.1-fpm php8.1-common php8.1-mysql \
    php8.1-xml php8.1-curl php8.1-mbstring php8.1-zip \
    php8.1-gd php8.1-bcmath php8.1-intl

# Install Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_16.x | sudo -E bash -
sudo apt-get install -y nodejs
```

## Application Deployment

### 1. Clone the Repository
```bash
# Create project directory
sudo mkdir -p /var/www/denr-tois
sudo chown -R $USER:$USER /var/www/denr-tois

# Clone the repository
git clone https://github.com/brandon3sican/denr-tois.git /var/www/denr-tois
cd /var/www/denr-tois
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies and build assets
npm install
npm run production
```

### 3. Environment Configuration
```bash
# Copy .env file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure .env with production settings
nano .env
```

### 4. Database Setup
```bash
# Create database and user
sudo mysql -u root -p
CREATE DATABASE denr_tois;
CREATE USER 'denr_tois_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON denr_tois.* TO 'denr_tois_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force
```

### 5. File Permissions
```bash
# Set proper permissions
sudo chown -R www-data:www-data /var/www/denr-tois/storage
sudo chown -R www-data:www-data /var/www/denr-tois/bootstrap/cache
sudo chmod -R 775 /var/www/denr-tois/storage
sudo chmod -R 775 /var/www/denr-tois/bootstrap/cache
```

## Web Server Configuration

### Nginx Configuration
```bash
# Create Nginx server block
sudo nano /etc/nginx/sites-available/denr-tois
```

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/denr-tois/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Enable the Site
```bash
# Create symlink
sudo ln -s /etc/nginx/sites-available/denr-tois /etc/nginx/sites-enabled/

# Test Nginx configuration
sudo nginx -t

# Restart Nginx
sudo systemctl restart nginx
```

## SSL Certificate (Let's Encrypt)
```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain and install certificate
sudo certbot --nginx -d yourdomain.com

# Test automatic renewal
sudo certbot renew --dry-run
```

## Queue Workers
```bash
# Configure Supervisor
sudo nano /etc/supervisor/conf.d/denr-tois-worker.conf
```

```ini
[program:denr-tois-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/denr-tois/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/denr-tois/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Start Supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start denr-tois-worker:*
```

## Scheduled Tasks
```bash
# Add to crontab
(crontab -l ; echo "* * * * * cd /var/www/denr-tois && php artisan schedule:run >> /dev/null 2>&1") | crontab -
```

## Deployment Script
Create a deployment script at `/var/www/denr-tois/deploy.sh`:

```bash
#!/bin/bash

# Change to project directory
cd /var/www/denr-tois

# Pull latest changes
git pull origin main

# Install/update dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run production

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
php artisan queue:restart
```

Make it executable:
```bash
chmod +x /var/www/denr-tois/deploy.sh
```

## Monitoring
- Set up monitoring for:
  - Disk space
  - Memory usage
  - CPU load
  - Nginx/Apache status
  - Queue workers

## Backup Strategy
1. Database backups (daily)
2. File backups (weekly)
3. Off-site storage
4. Test restoration process

## Security Considerations
- Keep server updated
- Use strong passwords
- Regular security audits
- Monitor logs
- Implement rate limiting
- Set up a firewall (UFW)
- Regular security patches

## Troubleshooting
- Check Laravel logs: `tail -f storage/logs/laravel.log`
- Check Nginx error logs: `tail -f /var/log/nginx/error.log`
- Check queue worker logs: `tail -f storage/logs/worker.log`
- Check storage permissions
- Verify .env configuration
- Clear caches if needed

## Rollback Procedure
1. Revert to previous Git commit
2. Run migrations if needed
3. Clear caches
4. Restart services
