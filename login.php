<?php 
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login - Hiranya&Co.</title>
    <link rel="stylesheet" href="assets/css/style.css?v=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <div class="logo">H</div>
        <h2>Sign in to your account</h2>
        <form action="login_process.php" method="POST">
            <input type="text" name="username" placeholder="Username*" required>
            <input type="password" name="password" placeholder="Password*" required>

            <div style="text-align: left;">
            <a href="#" class="forgot-pass">Forgot your password?</a>
            </div>
            
            <button type="submit" class="btn-signin">SIGN IN</button>
        </form>

        <a href="register.php" class="create-account">Create an account</a>
    </div>
</body>
</html>