<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artist_id  = $_SESSION['user_id'];
    $title      = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price      = $_POST['price'];
    $image_name = '';

    if (!empty($_FILES['artwork_image']['name'])) {
        $ext = strtolower(pathinfo(
            $_FILES['artwork_image']['name'],
            PATHINFO_EXTENSION
        ));
        $allowed = ['jpg','jpeg','png','webp'];

        if (!in_array($ext, $allowed)) {
            die("Format gambar tidak valid.");
        }
        $image_name = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file(
            $_FILES['artwork_image']['tmp_name'],
            'uploads/' . $image_name
        );
    }
    $status = 'available';
    $stmt = $conn->prepare("
        INSERT INTO artworks
        (
            artist_id,
            title,
            description,
            price,
            image_url,
            status
        )
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
        echo "Gagal menyimpan artwork.";
    }
}
?>