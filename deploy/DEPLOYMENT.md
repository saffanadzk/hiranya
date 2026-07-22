# VPS Deployment Guide - Hiranya Art House

This guide outlines the steps required to deploy the Hiranya application on a standard Ubuntu VPS running PHP 8.2+, Nginx (or Apache), and MySQL/MariaDB.

---

## 1. Server Prerequisites

Connect to your VPS via SSH and update package listings:
```bash
sudo apt update && sudo apt upgrade -y
```

Install the LAMP or LEMP stack packages (Nginx, PHP 8.2, MySQL):
```bash
sudo apt install -y nginx mariadb-server php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl php8.2-zip unzip git
```

---

## 2. Database Configuration

Secure your database installation:
```bash
sudo mysql_secure_installation
```

Login to MariaDB and create the database and user:
```sql
CREATE DATABASE hiranya CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hiranya_user'@'localhost' IDENTIFIED BY 'your_strong_password';
GRANT ALL PRIVILEGES ON hiranya.* TO 'hiranya_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Import your database structure:
```bash
mysql -u hiranya_user -p hiranya < /var/www/hiranya/database_backup.sql
```
*(Make sure to export your current local MySQL database and place it on the VPS server).*

---

## 3. Clone and Setup Application Directory

Clone your application repository to `/var/www/hiranya`:
```bash
sudo mkdir -p /var/www/hiranya
sudo chown -R $USER:$USER /var/www/hiranya
git clone https://github.com/yourusername/hiranya.git /var/www/hiranya
```

Install Composer globally if not already installed, then update dependencies:
```bash
cd /var/www/hiranya
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer install --no-dev --optimize-autoloader
```

Set file permissions so Nginx can write to upload folders and logs:
```bash
sudo chown -R www-data:www-data /var/www/hiranya/uploads
sudo chown -R www-data:www-data /var/www/hiranya/logs
sudo chmod -R 775 /var/www/hiranya/uploads
sudo chmod -R 775 /var/www/hiranya/logs
```

---

## 4. Environment Configuration

Modify `config.php` on the server to match database credentials:
```php
$conn = mysqli_connect("localhost", "hiranya_user", "your_strong_password", "hiranya");
```

Modify `mail_helper.php` to include your production SMTP credentials (e.g. Mailgun, SendGrid, Amazon SES, or local relays) to enable real email notifications.

---

## 5. Web Server Configuration (Nginx)

Copy the virtual host configuration from `deploy/nginx.conf` into Nginx sites-available:
```bash
sudo cp deploy/nginx.conf /etc/nginx/sites-available/hiranya.conf
sudo ln -s /etc/nginx/sites-available/hiranya.conf /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Enable SSL with Let's Encrypt
```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

---

## 6. Automated Deployments (`deploy.sh`)

To update your application automatically, you can run:
```bash
bash deploy/deploy.sh
```
This script automates pulling code updates, refreshing Composer dependencies, and checking MySQL database integrity.
