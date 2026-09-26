@echo off
title Laravel Local Server Runner

echo Optimizing and Caching Laravel

:: 1. Clear old cache and set new fresh cache FIRST
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache

echo Starting Laravel Application...

:: 2. Wait 1 second before starting background processes
timeout /t 1 >nul

:: 3. Start Laravel Development Server in background
start /b php artisan serve --port=8000

:: 4. Start Laravel Queue Worker in background
start /b php artisan queue:work --tries=3

:: 5. Wait 2 seconds for server to initialize
timeout /t 2 >nul

:: 6. Open default web browser to local app
start http://127.0.0.1:8000

echo Application running at http://127.0.0.1:8000
pause