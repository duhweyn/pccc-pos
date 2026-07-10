# PCCC POS Setup Guide (NexoPOS)

This guide gets NexoPOS running locally on Windows with XAMPP. Follow it in order, don't skip steps.

## 1. Install prerequisites

Install these first, in this order:

- **XAMPP** (PHP 8.1+ version) - apachefriends.org
- **Composer** - getcomposer.org. During install, point it to your XAMPP PHP: `C:\xampp\php\php.exe`
- **Node.js LTS** - nodejs.org (includes npm)
- **Git for Windows** - git-scm.com

Verify everything installed:
```
php -v
composer -v
node -v
npm -v
```
Each should print a version number. If any command isn't recognized, restart your terminal or your computer.

## 2. Enable required PHP extensions

XAMPP ships with these extensions but they're off by default. NexoPOS needs them.

1. Open XAMPP Control Panel → click **Config** next to Apache → **PHP (php.ini)**
2. Find these lines and remove the `;` in front of each:
```
extension=gd
extension=intl
extension=zip
extension=sodium
extension=mbstring
extension=fileinfo
extension=curl
extension=openssl
extension=pdo_mysql
```
3. Save the file
4. Restart Apache (Stop, then Start in XAMPP)
5. Confirm they loaded: `php -m` and check the extensions appear in the list

## 3. Clone the repo

```
cd C:\xampp\htdocs
git clone https://github.com/duhweyn/pccc-pos.git nexopos
cd nexopos
```

## 4. Install dependencies

```
composer install
```

If this fails with missing extension errors, go back to step 2, you missed one.

```
npm install
npm run build
```

Wait for `npm run build` to finish completely before moving on.

## 5. Set up the environment file

```
copy .env.example .env
php artisan key:generate
```

## 6. Create the database

1. Start **Apache** and **MySQL** in XAMPP Control Panel
2. Go to `http://localhost/phpmyadmin`
3. Click **New**, name it `nexopos_db`, click **Create**

## 7. Set up a virtual host (required, don't skip this)

Running the app from a subfolder URL (`localhost/nexopos/public`) breaks the installer with 404 errors on API calls. Set up a virtual host instead.

**a) Edit vhosts config** (open as Administrator):
```
C:\xampp\apache\conf\extra\httpd-vhosts.conf
```
Add at the bottom (adjust the path to match where you cloned the repo):
```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/nexopos/public"
    ServerName nexopos.test
    <Directory "C:/xampp/htdocs/nexopos/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**b) Edit the Windows hosts file** (open Notepad as Administrator, then open this file, switch the file filter to "All Files"):
```
C:\Windows\System32\drivers\etc\hosts
```
Add at the bottom:
```
127.0.0.1   nexopos.test
```

**c) Check mod_rewrite is enabled**

Open `C:\xampp\apache\conf\httpd.conf`, search for this line, make sure there's no `#` in front of it:
```
LoadModule rewrite_module modules/mod_rewrite.so
```

## 8. Set your `.env` to match the virtual host

Open `.env`, set:
```
APP_URL=http://nexopos.test
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nexopos_db
DB_USERNAME=root
DB_PASSWORD=
```

## 9. Clear cache and rebuild frontend

This step matters. If you change `APP_URL` after already running `npm run build` once, the old URL is baked into the compiled JS. Rebuild after any `.env` change to `APP_URL`.

```
php artisan config:clear
php artisan cache:clear
npm run build
```

## 10. Restart Apache and run the installer

1. Restart Apache fully in XAMPP (Stop, then Start)
2. Open a browser, go to `http://nexopos.test`
3. Follow the on-screen installer, it checks requirements, confirms the database connection, and creates your admin account

## Common errors and fixes

**"Call to undefined function [something]"**
Missing PHP extension. Go back to step 2, find the matching `extension=` line, uncomment it, restart Apache.

**POST to `/api/...` returns 404**
Your `.env` `APP_URL` doesn't match the URL in your browser, or you built the frontend before setting it correctly. Fix `.env`, then re-run:
```
php artisan config:clear
npm run build
```
Then hard refresh your browser (Ctrl+Shift+R).

**"Public Modules Directory: Incorrect Permissions" notification**
Safe to ignore on local Windows development. This matters more on real Linux hosting later.

**"Cron Disabled" notification**
Safe to ignore locally, nothing in day-to-day feature work depends on it. If you want it running anyway:
```
php artisan schedule:work
```
Leave that terminal window open while working.

## Login

Default install creates your own admin account during setup, no shared default password. Whoever runs the installer sets it then.

## Notes for the team

- Don't commit your `.env` file, it has your local database credentials. It's already excluded via `.gitignore`, but double check with `git status` before pushing if you're ever unsure.
- Each person runs their own local copy. Nobody shares a database, everyone's install is independent.
- If `composer install` or `npm install` ever behave strangely after pulling new changes, re-run both, dependencies get added over time.
