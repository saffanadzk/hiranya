<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Hiranya</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="main-wrapper">
        <div class="login-container">
            <div class="logo">H</div>
            <h2>Reset your password</h2>
            <p style="font-size: 13px; color: #555; margin-bottom: 25px;">Enter your email address and we'll send you a link to reset your password.</p>
            <form action="forgot_password_process.php" method="POST">
                <input type="email" name="email" placeholder="Email Address*" required>
                <button type="submit" class="btn-signin">SEND RESET LINK</button>
            </form>
            <a href="login.php" class="create-account">Back to Login</a>
        </div>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: '<?= htmlspecialchars($_SESSION['message_type'] == 'success' ? 'Success' : 'Notification'); ?>',
                text: '<?= htmlspecialchars($_SESSION['message']); ?>',
                icon: '<?= $_SESSION['message_type'] == 'danger' ? 'error' : ($_SESSION['message_type'] == 'success' ? 'success' : 'info'); ?>',
                confirmButtonColor: '#ab8e5b'
            });
        });
        </script>
        <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
    <?php endif; ?>
</body>
</html>
