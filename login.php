<?php include 'config.php';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $user = mysqli_fetch_assoc($result);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        header("Location: index.php");
    } else { $error = true; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login - Hiranya</title>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>Login Gagal!</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Welcome</button>
        </form>
        <a href="register.php">dont have an account? Register</a>
    </div>
</body>
</html>