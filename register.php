<?php
include 'config.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id  = (int)$_POST['role_id'];

    // Ambil role_name dari tabel roles berdasarkan role_id
    $role_query = mysqli_query($conn, "SELECT role_name FROM roles WHERE id = $role_id");
    $role_data  = mysqli_fetch_assoc($role_query);
    $role_name  = $role_data ? $role_data['role_name'] : 'customer';

    $cek = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah digunakan!";
    } else {
        mysqli_query($conn, "
            INSERT INTO users (username, email, password, role_id, role)
            VALUES ('$username', '$email', '$password', '$role_id', '$role_name')
        ");
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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