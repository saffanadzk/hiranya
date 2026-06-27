<?php
session_start();
include 'config.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];
$query = mysqli_query($conn, "
    SELECT users.*, roles.role_name
    FROM users
    LEFT JOIN roles ON users.role_id = roles.id
    WHERE username='$username'
");

if (mysqli_num_rows($query) == 1) {
    $user = mysqli_fetch_assoc($query);
    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role']     = $user['role_name'];

        if ($user['role_name'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        echo "Password salah!";
    }
} else {
    echo "Username tidak ditemukan!";
}
?>