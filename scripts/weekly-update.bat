@echo off
echo ============================================
echo  Dashboard IDP - Weekly Dependency Update
echo  %DATE% %TIME%
echo ============================================

cd /d "c:\laragon\www\dashboard-idp"

echo.
echo [1/4] Menjalankan composer audit...
composer audit
if %ERRORLEVEL% NEQ 0 (
    echo PERINGATAN: Ada vulnerability ditemukan!
)

echo.
echo [2/4] Update dependency minor (patch/minor versions)...
composer update --no-dev --prefer-stable --with-all-dependencies

echo.
echo [3/4] Clear cache Laravel...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo.
echo [4/4] Audit npm packages...
npm audit

echo.
echo ============================================
echo  Update selesai: %DATE% %TIME%
echo ============================================
pause
