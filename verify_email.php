<?php
session_start();
require_once 'config.php';

$token = isset($_GET['token']) ? mysqli_real_escape_string($conn, $_GET['token']) : '';

if (empty($token)) {
    $_SESSION['message'] = "Invalid or missing verification token!";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

$query = mysqli_query($conn, "SELECT id, username FROM users WHERE verification_token = '$token'");

if (mysqli_num_rows($query) === 1) {
    $user = mysqli_fetch_assoc($query);
    $user_id = $user['id'];
    $username = $user['username'];
    
    mysqli_query($conn, "UPDATE users SET email_verified = 1, verification_token = NULL WHERE id = $user_id");
    
    $_SESSION['message'] = "Email verified successfully! Welcome, @$username. You can now sign in.";
    $_SESSION['message_type'] = "success";
    header("Location: login.php");
    exit();
} else {
    $_SESSION['message'] = "Invalid verification link or the account is already verified.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}
?>
