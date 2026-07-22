<?php
include 'config.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id  = (int)$_POST['role_id'];

    $role_query = mysqli_query($conn, "SELECT role_name FROM roles WHERE id = $role_id");
    $role_data  = mysqli_fetch_assoc($role_query);
    $role_name  = $role_data ? $role_data['role_name'] : 'customer';

    $cek = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $verification_token = bin2hex(random_bytes(32));
        $stmt = mysqli_prepare($conn, "
            INSERT INTO users (username, email, password, role_id, role, verification_token, email_verified)
            VALUES (?, ?, ?, ?, ?, ?, 1)
        ");
        mysqli_stmt_bind_param($stmt, "sssiss", $username, $email, $password, $role_id, $role_name, $verification_token);
        
        if (mysqli_stmt_execute($stmt)) {
            require_once 'mail_helper.php';
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
            $verify_link = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/hiranya/verify_email.php?token=" . $verification_token;
            
            $subject = "Welcome to Hiranya Art House";
            $body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #fdfdfd;'>
                    <div style='text-align: center; border-bottom: 2px solid #ab8e5b; padding-bottom: 10px;'>
                        <h2 style='color: #1c2431; font-family: \"Cinzel\", serif;'>Hiranya Art House</h2>
                    </div>
                    <div style='padding: 20px 0;'>
                        <h3 style='color: #ab8e5b;'>Welcome to Hiranya, @$username!</h3>
                        <p style='color: #555; line-height: 1.6;'>Thank you for registering on our platform. Your account is successfully activated and verified.</p>
                        <p style='color: #555;'>You can now explore, bid on auctions, and manage your art collections.</p>
                    </div>
                    <div style='border-top: 1px solid #eee; padding-top: 15px; text-align: center; color: #aaa; font-size: 11px;'>
                        <p>&copy; " . date('Y') . " Hiranya Art House. All rights reserved.</p>
                    </div>
                </div>
            ";
            
            // Try sending welcome email (logged/sent but doesn't block login if SMTP fails)
            send_email($email, $subject, $body);
            
            $_SESSION['message'] = "Registration successful! Your account is active. You can now log in immediately.";
            $_SESSION['message_type'] = "success";
            header("Location: login.php");
            exit;
        } else {
            $error = "Failed to register account. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hiranya</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="main-wrapper">
    <div class="login-container">
        <div class="logo">H</div>
        <h2>Create an account</h2>

        <?php if (isset($error)) : ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="text"     name="username" placeholder="Username*"       required>
            <input type="email"    name="email"    placeholder="Email Address*"  required>
            <input type="password" name="password" placeholder="Password*"       required>

            <div class="register-as-wrapper">
                <label for="registerAs">Register As</label>
                <select id="registerAs" name="role_id" class="register-as-select" required>
                    <option value="">— Select Role —</option>
                    <option value="1">Customer</option>
                    <option value="2">Artist</option>
                </select>
            </div>

            <button type="submit" name="register" class="btn-signin">REGISTER</button>
        </form>

        <a href="login.php" class="create-account">Already have an account? Login</a>
    </div>
</div>
</body>
</html>