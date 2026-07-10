<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

// Ambil semua artist yang punya karya available (direct sale, bukan dibeli Hiranya)
$artists_query = mysqli_query($conn, "
    SELECT DISTINCT u.id, u.username, u.email,
           ap.profile_image, ap.bio, ap.website,
           COUNT(a.id) AS artwork_count
    FROM users u
    LEFT JOIN artist_profiles ap ON u.id = ap.user_id
    LEFT JOIN artworks a ON u.id = a.artist_id
        AND a.moderation_status = 'Approved'
        AND a.sale_status = 'available'
    WHERE u.role_id = 2
    GROUP BY u.id
    ORDER BY artwork_count DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Buy Privately | Hiranya House</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/discover.css" rel="stylesheet">
    <link href="assets/css/buy-privately.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@400;500;700&family=Work+Sans:wght@300;400;500&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body class="discover-page">

    <?php include 'partials/navbar.php'; ?>

    <div class="discover-page-head">
        <div class="container">
            <h1 class="font-playfair-display mb-2">Buy Privately</h1>
            <p class="discover-sub">Acquire works directly from our represented artists — exclusive, personal, and curated for you</p>
            <ul class="auction-subtabs">
                <li><a href="private-sale.php">Available Works</a></li>
                <li><a href="buy-privately.php" class="active">Buy Privately</a></li>
                <li><a href="featured-collections.php">Featured Collections</a></li>
            </ul>
        </div>
    </div>

    <div class="container py-5">

        <div class="bp-intro row align-items-center mb-5 g-4">
            <div class="col-md-8">
                <h2 class="bp-intro-title">Meet Our Artists</h2>
                <p class="bp-intro-sub">Each artist on this page sells directly to collectors through Hiranya. Browse their profiles, explore their available works, and acquire pieces outside the auction room — at the artist's own price, with a 5% platform fee.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="bp-count-badge"><?= mysqli_num_rows($artists_query); ?> Artist<?= mysqli_num_rows($artists_query) != 1 ? 's' : ''; ?> Available</span>
            </div>
        </div>

        <?php if (mysqli_num_rows($artists_query) === 0): ?>
            <div class="text-center py-5">
                <i class="fa fa-palette fa-3x mb-3" style="color: #ab8e5b; opacity:.5;"></i>
                <p class="text-muted">Belum ada artist yang tersedia untuk private sale saat ini.</p>
                <a href="register.php" class="btn-card-solid mt-3" style="display:inline-block; padding:12px 28px;">Daftar Sebagai Artist</a>
            </div>
        <?php else: ?>
            <div class="bp-artist-grid">
                <?php while ($artist = mysqli_fetch_assoc($artists_query)): ?>
                    <div class="bp-artist-card">
                        <a href="artist_profile.php?id=<?= $artist['id']; ?>" class="bp-card-link">

                            <!-- Foto / Avatar -->
                            <div class="bp-card-photo">
                                <?php if (!empty($artist['profile_image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($artist['profile_image']); ?>"
                                         alt="<?= htmlspecialchars($artist['username']); ?>">
                                <?php else: ?>
                                    <div class="bp-card-initials">
                                        <?= strtoupper(substr($artist['username'], 0, 1)); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Garis aksen kiri seperti referensi -->
                                <div class="bp-card-accent"></div>

                                <!-- Overlay bawah: nama + role + ikon sosial -->
                                <div class="bp-card-overlay">
                                    <div class="bp-card-role">Hiranya Artist</div>
                                    <h5 class="bp-card-name"><?= htmlspecialchars($artist['username']); ?></h5>
                                    <div class="bp-card-socials">
                                        <span class="bp-social-btn"><i class="fab fa-facebook-f"></i></span>
                                        <span class="bp-social-btn"><i class="fab fa-instagram"></i></span>
                                        <?php if (!empty($artist['website'])): ?>
                                            <span class="bp-social-btn"><i class="fa fa-globe"></i></span>
                                        <?php else: ?>
                                            <span class="bp-social-btn"><i class="fab fa-linkedin-in"></i></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Info bawah card -->
                            <div class="bp-card-body">
                                <p class="bp-card-bio">
                                    <?= !empty($artist['bio'])
                                        ? htmlspecialchars(substr($artist['bio'], 0, 70)) . (strlen($artist['bio']) > 70 ? '...' : '')
                                        : 'Artist represented by Hiranya Art House'; ?>
                                </p>
                                <div class="bp-card-footer">
                                    <span class="bp-works-count">
                                        <i class="fa fa-image me-1"></i>
                                        <?= $artist['artwork_count']; ?> work<?= $artist['artwork_count'] != 1 ? 's' : ''; ?>
                                    </span>
                                    <span class="bp-view-profile">View Profile →</span>
                                </div>
                            </div>

                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- CTA section -->
    <div class="bp-cta-section">
        <div class="container text-center">
            <span class="bp-cta-eyebrow">ARE YOU AN ARTIST?</span>
            <h3 class="bp-cta-title">Join Hiranya and Sell Your Work Privately</h3>
            <p class="bp-cta-sub">Register as an artist, submit your artwork, and reach serious collectors through our curated platform.</p>
            <a href="register.php" class="bp-cta-btn">REGISTER AS ARTIST</a>
        </div>
    </div>

    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5">
        <div class="container py-4 text-center">
            <p>&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>