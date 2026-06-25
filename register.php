<?php include 'config.php';
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Register - Hiranya</title>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register">Register</button>
        </form>
        <a href="login.php">Already have an account? Login</a>
    </div>
</body>
</html>