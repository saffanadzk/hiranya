<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

// Validasi admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['message'] = "Akses ditolak! Anda harus masuk sebagai admin.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = mysqli_prepare($conn, "SELECT artworks.*, users.username AS artist_name FROM artworks LEFT JOIN users ON artworks.artist_id = users.id WHERE artworks.id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    $_SESSION['message'] = "Karya seni tidak ditemukan!";
    $_SESSION['message_type'] = "danger";
    header("Location: admin_dashboard.php");
    exit;
}

if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc  = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (double)$_POST['price'];

    if (!empty($title)) {
        $upd = mysqli_prepare($conn, "UPDATE artworks SET title=?, description=?, price=? WHERE id=?");
        mysqli_stmt_bind_param($upd, "ssdi", $title, $desc, $price, $id);
        
        if (mysqli_stmt_execute($upd)) {
            $_SESSION['message'] = "Metadata karya seni berhasil diperbarui!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal memperbarui karya seni: " . mysqli_error($conn);
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Judul tidak boleh kosong!";
        $_SESSION['message_type'] = "warning";
    }

    header("Location: admin_dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Artwork (Admin) - Hiranya</title>
    
    <link href="assets/img/favicon.ico" rel="icon">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Work+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="admin-edit-page">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="edit-card">
                
                <div class="edit-header">
                    <h2>Edit Detail Karya Seni</h2>
                    <p class="mb-0 text-muted" style="color: #cbd5e1 !important;">Diunggah oleh @<?= htmlspecialchars($data['artist_name']); ?></p>
                </div>
                
                <div class="edit-body">
                    <form method="POST">
                        
                        <div class="text-center mb-4">
                            <img src="uploads/<?= htmlspecialchars($data['image_url']); ?>" class="img-thumbnail shadow-sm" style="max-height: 250px; object-fit: cover;" alt="">
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Karya Seni</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($data['title']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($data['description']); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="form-label">Harga (IDR)</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background-color: #f1f3f5;">Rp</span>
                                <input type="number" class="form-control" id="price" name="price" step="1" min="0" value="<?= $data['price']; ?>" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="admin_dashboard.php" class="btn btn-outline-navy"><i class="fa fa-arrow-left me-1"></i> Batal</a>
                            <button type="submit" name="update" class="btn btn-gold"><i class="fa fa-save me-1"></i> Perbarui Karya Seni</button>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

</body>
</html>
