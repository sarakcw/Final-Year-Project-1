# Wine E-commerce — CakePHP Application

This is a group project built by three developers as part of a university web systems development unit.
The application was created for a fictional business client and enables staff to manage products, coupons,
orders, and customer data through a secure and modular CakePHP-based web system.
It was designed with maintainability and future scalability in mind.
## Features

- User-friendly wine browsing with advanced filtering
- Shopping cart with item quantity management
- Admin panel to manage products and orders
- Dynamic filter support by category
- MySQL database with phpMyAdmin

---

## 🛠️ Installation & Setup

### Prerequisites

- PHP >= 8.1
- MySQL / MariaDB
- Composer
- Apache or built-in CakePHP web server
- Google reCAPTCHA v2 integration on login and registration forms
- phpMyAdmin (optional, for GUI database management)

---

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/divine-vines.git
cd divine-vines
```
### 2. Install dependencies

```bash
composer install
```

### 3. Configure Database Connection
1. Navigate to `config/app_local.php`
2. Import the `database.sql` to your phpMyAdmin
3. Update the `config/app_local.php` file with your phpMyAdmin/MySQL credentials

### 4. Google Recaptcha setup
1. Visit Google reCAPTCHA Admin console [https://www.google.com/recaptcha/admin/create]
2. Register your site:
   - Choose reCAPTCHA v2
   - Add your domain
3. Create .env file

```bash
RECAPTCHA_SITE_KEY=your_site_key_here
RECAPTCHA_SECRET_KEY=your_secret_key_here
```

### 4. Start the server

```bash
bin/cake server
```
