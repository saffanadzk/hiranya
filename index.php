<?php include 'config.php';
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Dashboard Hiranya</title>
</head>
<body>
    <h1>Welcome to Hiranya House</h1>
    <a href="logout.php">Logout</a>
    </body>
</html>