<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head><title>Submit Artwork</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body>
    <div class="login-container">
        <h2>Submit Artwork</h2>
        <form action="process_submit.php" method="POST" enctype="multipart/form-data">
            <input type="text"
                name="title"
                placeholder="Artwork Title"
                required>
            <textarea
                name="description"
                placeholder="Description"></textarea>
            <input type="number"
                step="0.01"
                name="price"
                placeholder="Price">
            <input type="file"
                name="artwork_image"
                required>
            <button type="submit">
                Submit Artwork
            </button>
        </form>
    </div>
</body>
</html>