<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: index.php");
    exit();
}

include 'config.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Customer - Hiranya</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="main-wrapper">
    <div class="login-container">
        <h1>Dashboard Customer</h1>
        <p>
            Selamat datang,
            <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
        </p>
        <hr>
        <h3>Menu Customer</h3>
        <ul>
            <li><a href="artists.php">Lihat Artist</a></li>
            <li><a href="artworks.php">Lihat Artwork</a></li>
            <li><a href="auctions.php">Auction</a></li>
            <li><a href="my_bids.php">Riwayat Bid</a></li>
            <li><a href="profile.php">Profil Saya</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>
</body>
</html>