# Setup script for NJ-Car-Rentals development environment
Write-Host "Setting up NJ-Car-Rentals development environment..." -ForegroundColor Green

# Add XAMPP to PATH
$env:PATH = "C:\xampp\php;C:\xampp\mysql\bin;" + $env:PATH

# Verify tools
Write-Host "`n[1/4] Checking PHP installation..." -ForegroundColor Cyan
$phpVersion = php -r "echo PHP_VERSION_ID;"
if ([int]$phpVersion -lt 80200) {
    Write-Host "❌ Error: You are running PHP $(php -r 'echo PHP_VERSION;'). This project requires PHP 8.2+." -ForegroundColor Red
    Write-Host "Please upgrade XAMPP to the latest version to get PHP 8.2." -ForegroundColor Yellow
    Write-Host "Download updated XAMPP here: https://www.apachefriends.org/download.html" -ForegroundColor Cyan
    exit 1
}
php -v

Write-Host "`n[2/4] Installing Composer dependencies..." -ForegroundColor Cyan
php C:\xampp\php\composer.phar install

Write-Host "`n[3/4] Running Laravel migrations..." -ForegroundColor Cyan
php artisan migrate --force

Write-Host "`n[4/4] Checking for Node.js..." -ForegroundColor Cyan
if (Get-Command node -ErrorAction SilentlyContinue) {
    Write-Host "Node.js is installed: $(node -v)" -ForegroundColor Green
    Write-Host "npm is installed: $(npm -v)" -ForegroundColor Green
    Write-Host "Installing frontend dependencies..." -ForegroundColor Cyan
    npm install
    Write-Host "Building frontend..." -ForegroundColor Cyan
    npm run build
} else {
    Write-Host "Node.js is NOT installed. You need to install it manually from https://nodejs.org/" -ForegroundColor Yellow
    Write-Host "After installing Node.js, run: npm install && npm run build" -ForegroundColor Yellow
}

Write-Host "`n✅ Setup complete!" -ForegroundColor Green
Write-Host "`nTo start the development server, run:" -ForegroundColor Cyan
Write-Host "  php artisan serve" -ForegroundColor Yellow
Write-Host "`nOr for full stack (with logs and queue):" -ForegroundColor Cyan
Write-Host "  npm install -g concurrently (if not installed)" -ForegroundColor Yellow
Write-Host "  php artisan serve & php artisan queue:listen & php artisan pail" -ForegroundColor Yellow

$response = Read-Host "`nDo you want to start the server now? (Y/n)"
if ($response -ne 'n') {
    php artisan serve
}
