<?php
require_once 'config.php';

// Ambil artworks available, limit 6 untuk homepage
$stmt = mysqli_prepare($conn,
    "SELECT a.*, u.username as artist_name, c.name as category_name
     FROM artworks a
     LEFT JOIN users u ON a.artist_id = u.id
     LEFT JOIN categories c ON a.category_id = c.id
     WHERE a.status = 'available'
     ORDER BY a.id DESC
     LIMIT 6");
mysqli_stmt_execute($stmt);
$artworks = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
?>
<head>
    <meta charset="utf-8">
    <title>My Account - Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="assets/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<!-- EXPLORE GALLERY SECTION -->
<section class="gallery-section py-5">
    <div class="container">

        <!-- Header -->
        <div class="gallery-section-head">
            <span class="gallery-eyebrow">Our Collection</span>
            <h2 class="gallery-title">Explore the Gallery</h2>
            <p class="gallery-sub">Discover extraordinary works from our curated artists</p>
        </div>

        <!-- Grid -->
        <div class="gallery-browse-grid">
            <?php foreach($artworks as $art): ?>
            <div class="gallery-browse-card">

                <a href="artwork_detail.php?id=<?php echo $art['id']; ?>" class="gallery-browse-img">
                    <img src="uploads/<?php echo htmlspecialchars($art['image_url']); ?>"
                         alt="<?php echo htmlspecialchars($art['title']); ?>">
                    <div class="gallery-browse-overlay">
                        <span class="gallery-browse-view">View Artwork</span>
                    </div>
                </a>

                <div class="gallery-browse-body">
                    <?php if($art['category_name']): ?>
                    <span class="gallery-browse-cat"><?php echo htmlspecialchars($art['category_name']); ?></span>
                    <?php endif; ?>
                    <h5 class="gallery-browse-title">
                        <a href="artwork_detail.php?id=<?php echo $art['id']; ?>">
                            <?php echo htmlspecialchars($art['title']); ?>
                        </a>
                    </h5>
                    <p class="gallery-browse-artist">by <?php echo htmlspecialchars($art['artist_name']); ?></p>
                    <div class="gallery-browse-footer">
                        <span class="gallery-browse-price">
                            Rp <?php echo number_format($art['price'], 0, ',', '.'); ?>
                        </span>
                        <a href="artwork_detail.php?id=<?php echo $art['id']; ?>" class="gallery-browse-btn">
                            Details
                        </a>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol lihat semua -->
        <div class="gallery-browse-more">
            <a href="browse.php" class="btn-browse-all">
                Browse All Artworks
                <span class="btn-browse-line"></span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>
</section>