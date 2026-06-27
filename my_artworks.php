<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') {
    header("Location: login.php");
    exit;
}

$artist_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM artworks WHERE artist_id = ?");
$stmt->bind_param("i", $artist_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Artworks</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="login-container">
    <h2>My Artworks</h2>
    <p>
        <a href="submit_artwork.php">Tambah Artwork</a> |
        <a href="dashboard.php">Dashboard</a>
    </p>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div style="border:1px solid #ddd;padding:15px;margin-bottom:15px;">
                <?php if (!empty($row['image_url'])): ?>
                    <img
                        src="<?= htmlspecialchars($row['image_url']) ?>"
                        width="150"
                        alt="Artwork">
                    <br><br>
                <?php endif; ?>
                <strong>
                    <?= htmlspecialchars($row['title']) ?>
                </strong>
                <br>
                Harga:
                Rp <?= number_format($row['price'],0,',','.') ?>
                <br>
                Status:
                <em><?= htmlspecialchars($row['status']) ?></em>
                <br><br>
                <a href="edit.php?id=<?= (int)$row['id'] ?>">
                    Edit
                </a>
                |
                <a href="delete.php?id=<?= (int)$row['id'] ?>"
                   onclick="return confirm('Yakin ingin menghapus artwork ini?')">
                    Hapus
                </a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Belum ada artwork yang ditambahkan.</p>
    <?php endif; ?>

</div>

</body>
</html>