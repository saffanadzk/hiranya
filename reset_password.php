<?php
session_start();
include 'config.php';

$token = isset($_GET['token']) ? mysqli_real_escape_string($conn, $_GET['token']) : '';
$email = isset($_GET['email']) ? mysqli_real_escape_string($conn, $_GET['email']) : '';

if (empty($token) || empty($email)) {
    $_SESSION['message'] = "Invalid or expired reset link.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

// Verify token
$now = date('Y-m-d H:i:s');
$query = mysqli_query($conn, "
    SELECT * FROM password_resets 
    WHERE email = '$email' AND token = '$token' AND expires_at > '$now'
    ORDER BY id DESC LIMIT 1
");

if (mysqli_num_rows($query) === 0) {
    $_SESSION['message'] = "The reset link is invalid or has expired.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Hiranya</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="main-wrapper">
        <div class="login-container">
            <div class="logo">H</div>
            <h2>Create New Password</h2>
            <p style="font-size: 13px; color: #555; margin-bottom: 25px;">Please enter your new password below.</p>
            <form action="reset_password_process.php" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                <input type="password" name="password" placeholder="New Password*" required minlength="6">
                <input type="password" name="confirm_password" placeholder="Confirm New Password*" required minlength="6">
                <button type="submit" class="btn-signin">RESET PASSWORD</button>
            </form>
            <a href="login.php" class="create-account">Cancel</a>
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
