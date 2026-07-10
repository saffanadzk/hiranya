<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
    $bank_account = mysqli_real_escape_string($conn, $_POST['bank_account']);
    $bank_holder = mysqli_real_escape_string($conn, $_POST['bank_holder']);

    // Check if artist_profiles exists
    $check = mysqli_query($conn, "SELECT id FROM artist_profiles WHERE user_id = $user_id");
    if (mysqli_num_rows($check) > 0) {
        $query = "UPDATE artist_profiles SET bank_name = ?, bank_account = ?, bank_holder = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $bank_name, $bank_account, $bank_holder, $user_id);
    } else {
        $query = "INSERT INTO artist_profiles (user_id, bank_name, bank_account, bank_holder) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "isss", $user_id, $bank_name, $bank_account, $bank_holder);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Detail transfer bank berhasil diperbarui!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal memperbarui detail bank: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }
}

header("Location: profile.php");
exit;
?>
