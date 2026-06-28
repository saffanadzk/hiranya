<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $artist_id  = $_SESSION['user_id'];
    $title      = $_POST['title'];
    $description = $_POST['description'];
    $price      = $_POST['price'];

    // Folder upload
    $upload_dir = "uploads/";

    // Buat folder jika belum ada
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Upload gambar
    $image_name = '';

    if (isset($_FILES['artwork_image']) && $_FILES['artwork_image']['error'] == 0) {

        $ext = strtolower(pathinfo($_FILES['artwork_image']['name'], PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allowed)) {
            die("Format gambar harus JPG, JPEG, PNG, atau WEBP");
        }

        $image_name = time() . '_' . uniqid() . '.' . $ext;

        if (!move_uploaded_file(
            $_FILES['artwork_image']['tmp_name'],
            $upload_dir . $image_name
        )) {
            die("Gagal upload gambar.");
        }
    }

    $status = "available";

    $stmt = $conn->prepare("
        INSERT INTO artworks
        (artist_id, title, description, price, image_url, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issdss",
        $artist_id,
        $title,
        $description,
        $price,
        $image_name,
        $status
    );

    if ($stmt->execute()) {
        header("Location: my_artworks.php");
        exit;
    } else {
        echo "Gagal menyimpan artwork: " . $conn->error;
    }
}
?>