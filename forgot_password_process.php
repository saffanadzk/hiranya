<?php
session_start();
require_once 'config.php';
require_once 'mail_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';

    if (empty($email)) {
        $_SESSION['message'] = "Please enter your email address.";
        $_SESSION['message_type'] = "danger";
        header("Location: forgot_password.php");
        exit();
    }

    // Check if user exists
    $query = mysqli_query($conn, "SELECT id, username FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);
        $username = $user['username'];
        
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Save token to password_resets table
        $stmt = mysqli_prepare($conn, "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $email, $token, $expires_at);
        mysqli_stmt_execute($stmt);

        // Send Reset Link Email
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $reset_link = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/hiranya/reset_password.php?token=" . $token . "&email=" . urlencode($email);
        
        $subject = "Reset Your Password - Hiranya Art House";
        $body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #fdfdfd;'>
                <div style='text-align: center; border-bottom: 2px solid #ab8e5b; padding-bottom: 10px;'>
                    <h2 style='color: #1c2431; font-family: \"Cinzel\", serif;'>Hiranya Art House</h2>
                </div>
                <div style='padding: 20px 0;'>
                    <h3 style='color: #ab8e5b;'>Password Reset Request</h3>
                    <p style='color: #555; line-height: 1.6;'>Hello, @$username,</p>
                    <p style='color: #555; line-height: 1.6;'>We received a request to reset the password for your account associated with this email. To proceed, please click the button below. This link is valid for 1 hour.</p>
                    <div style='text-align: center; margin: 30px 0;'>
                        <a href='$reset_link' style='background-color: #ab8e5b; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 15px; display: inline-block;'>Reset Password</a>
                    </div>
                    <p style='color: #777; font-size: 12px; text-align: center;'>If the button above doesn't work, copy and paste this URL into your browser:<br><a href='$reset_link' style='color: #ab8e5b;'>$reset_link</a></p>
                    <p style='color: #999; font-size: 13px;'>If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>
                </div>
                <div style='border-top: 1px solid #eee; padding-top: 15px; text-align: center; color: #aaa; font-size: 11px;'>
                    <p>&copy; " . date('Y') . " Hiranya Art House. All rights reserved.</p>
                </div>
            </div>
        ";
        
        send_email($email, $subject, $body);
        
        $_SESSION['message'] = "We have sent a password reset link to your email address.";
        $_SESSION['message_type'] = "success";
    } else {
        // We'll tell them the email was not found
        $_SESSION['message'] = "No account found with that email address.";
        $_SESSION['message_type'] = "danger";
    }
    
    header("Location: forgot_password.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
