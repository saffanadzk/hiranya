<?php
// Database Configuration (Local XAMPP / InfinityFree Production)
$db_host = getenv('DB_HOST') ?: "localhost";
$db_user = getenv('DB_USER') ?: "root";
$db_pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
$db_name = getenv('DB_NAME') ?: "hiranya";

/*
 * CONTOH PENGATURAN UNTUK INFINITYFREE HOSTING:
 * Ubah variabel di bawah jika dideploy ke InfinityFree (tanpa getenv):
 * 
 * $db_host = "sqlXXX.infinityfree.com"; // MySQL Hostname dari InfinityFree
 * $db_user = "if0_38XXXXXX";           // MySQL Username dari InfinityFree
 * $db_pass = "password_vpanel_anda";   // MySQL Password dari InfinityFree
 * $db_name = "if0_38XXXXXX_hiranya";   // Database Name dari InfinityFree
 */

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$theme_class = (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') ? 'dark-mode' : '';
?>