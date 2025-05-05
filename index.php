<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// =============================================
// AKTIFKAN ERROR REPORTING (TAMBAHKAN DI BAWAH INI)
// =============================================
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__.'/storage/logs/php_errors.log');
// =============================================

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

try {
    // Register the Composer autoloader...
    if (!file_exists(__DIR__.'/vendor/autoload.php')) {
        throw new RuntimeException('Vendor autoload tidak ditemukan. Jalankan composer install.');
    }
    require __DIR__.'/vendor/autoload.php';

    // Bootstrap Laravel and handle the request...
    $app = require_once __DIR__.'/bootstrap/app.php';
    
    if (!$app) {
        throw new RuntimeException('Gagal memuat aplikasi Laravel');
    }
    
    $response = $app->handleRequest(Request::capture());
    $response->send();
    
} catch (Throwable $e) {
    // =============================================
    // TAMPILKAN ERROR DETAIL (TAMBAHKAN INI)
    // =============================================
    header('Content-Type: text/html; charset=utf-8');
    echo '<h1>Terjadi Error</h1>';
    echo '<h2>'.$e->getMessage().'</h2>';
    echo '<pre>';
    echo 'File: '.$e->getFile().' (Line: '.$e->getLine().")\n\n";
    echo 'Stack Trace:'."\n";
    echo htmlspecialchars($e->getTraceAsString());
    echo '</pre>';
    
    // Log error ke file
    error_log($e->getMessage());
    error_log($e->getTraceAsString());
    // =============================================
}