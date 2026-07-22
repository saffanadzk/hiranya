<?php
// Deteksi otomatis apakah dijalankan di localhost komputer atau server online (InfinityFree)
$is_localhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) 
                || $_SERVER['HTTP_HOST'] === 'localhost' 
                || strpos($_SERVER['HTTP_HOST'], '192.168.') === 0;

if ($is_localhost) {
    // 🖥️ PENGATURAN DATABASE LOKAL (XAMPP KOMPUTER)
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "hiranya";
} else {
    // 🌐 PENGATURAN DATABASE ONLINE (SERVER INFINITYFREE)
    $db_host = "sql110.infinityfree.com";
    $db_user = "if0_42467177";
    $db_name = "if0_42467177_hiranya";
    
    // GANTI TULISAN DI BAWAH INI DENGAN PASSWORD KUNCI VPANEL / HOSTING ANDA
    $db_pass = "gimanaleee"; 
}

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$theme_class = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') ? 'dark-mode' : '';
?>