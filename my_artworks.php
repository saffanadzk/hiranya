<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$artist_id = $_SESSION['user_id'];

$sql = "SELECT * FROM artworks WHERE artist_id = ? ORDER BY id DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $artist_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Artworks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="my-artworks-page">

<nav class="navbar navbar-expand-lg sticky-top px-4 py-3" style="background:#1C2431;">
    <a href="index.php" class="navbar-brand">
        <span style="font-family:'Cinzel',serif; color:#fff; font-size:20px; font-weight:700; letter-spacing:2px;">Hiranya</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center gap-2">
            <li class="nav-item">
                <a href="profile.php" class="btn-backprofile-nav">Back to Profile</a>
            </li>
        </ul>
    </div>
</nav>

<div class="artworks-page-wrapper">

    <div class="artworks-page-head">
        <h1>My Artworks</h1>
        <div class="title-underline"></div>
    </div>

    <div class="artworks-grid">
        <?php while($art = mysqli_fetch_assoc($result)): ?>
        <div class="art-card">

            <div class="art-card-img">
                <img src="uploads/<?php echo htmlspecialchars($art['image_url']); ?>"
                     alt="<?php echo htmlspecialchars($art['title']); ?>">

                <div class="art-menu">
                    <button class="art-menu-btn" onclick="toggleMenu(this)">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="art-menu-dropdown">
                        <a href="edit_artwork.php?id=<?php echo $art['id']; ?>">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <a href="delete.php?id=<?php echo $art['id']; ?>"
                           onclick="return confirm('Hapus artwork ini?')"
                           class="delete-link">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </div>
                </div>
            </div>

            <div class="art-card-body">
                <h5 class="art-title"><?php echo htmlspecialchars($art['title']); ?></h5>
                <p class="art-desc"><?php echo htmlspecialchars($art['description']); ?></p>
                <div class="art-price">Rp <?php echo number_format($art['price'], 0, ',', '.'); ?></div>
                <span class="art-status available">Available</span>
            </div>

        </div>
        <?php endwhile; ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleMenu(btn) {
    const dropdown = btn.nextElementSibling;
    
    document.querySelectorAll('.art-menu-dropdown.show').forEach(d => {
        if (d !== dropdown) d.classList.remove('show');
    });
    dropdown.classList.toggle('show');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.art-menu')) {
        document.querySelectorAll('.art-menu-dropdown.show').forEach(d => d.classList.remove('show'));
    }
});
</script>
</body>
</html>