<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token            = isset($_POST['token']) ? mysqli_real_escape_string($conn, $_POST['token']) : '';
    $email            = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password         = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    if (empty($token) || empty($email) || empty($password)) {
        $_SESSION['message'] = "All fields are required.";
        $_SESSION['message_type'] = "danger";
        header("Location: reset_password.php?token=" . urlencode($token) . "&email=" . urlencode($email));
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        $_SESSION['message_type'] = "danger";
        header("Location: reset_password.php?token=" . urlencode($token) . "&email=" . urlencode($email));
        exit();
    }

    $now = date('Y-m-d H:i:s');
    $query = mysqli_query($conn, "
        SELECT * FROM password_resets 
        WHERE email = '$email' AND token = '$token' AND expires_at > '$now'
        ORDER BY id DESC LIMIT 1
    ");

    if (mysqli_num_rows($query) === 0) {
        $_SESSION['message'] = "The reset token is invalid or has expired.";
        $_SESSION['message_type'] = "danger";
        header("Location: login.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $upd_stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE email = ?");
    mysqli_stmt_bind_param($upd_stmt, "ss", $hashed_password, $email);
    
    if (mysqli_stmt_execute($upd_stmt)) {
        // Clear all reset tokens for this email
        mysqli_query($conn, "DELETE FROM password_resets WHERE email = '$email'");
        
        $_SESSION['message'] = "Password reset successful! You can now log in with your new password.";
        $_SESSION['message_type'] = "success";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['message'] = "Failed to update password. Please try again.";
        $_SESSION['message_type'] = "danger";
        header("Location: reset_password.php?token=" . urlencode($token) . "&email=" . urlencode($email));
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
