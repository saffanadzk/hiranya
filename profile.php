<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
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
    <link href="assets/css/profile.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid bg-light sticky-top p-0">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm py-3 px-4" style="background-color: #1C2431;">
            <a href="dashboard.php" class="navbar-brand me-5">
                <h1 class="mb-0 text-light">Hiranya</h1>
            </a>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                
                <div class="d-flex align-items-center ms-auto">
                    <form class="d-flex align-items-center me-4">
                        <input class="form-control me-2" type="search" placeholder="Search..."
                            style="width:180px;border:none;border-bottom:1px solid #f5f5f5;border-radius:0;box-shadow:none;background:transparent;">
                        <button type="submit" class="btn p-0" style="background:none;border:none;">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                    <a href="profile.php" class="text-primary me-3">
                        <i class="fa fa-user fa-lg"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
<!-- Profile hero background -->
    <div class="profile-hero"></div>
    <div class="container" style="margin-top: -90px;">
        <div class="profile-card">
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
                <div class="profile-avatar">
                    <?= htmlspecialchars(strtoupper(substr($_SESSION['username'], 0, 1))) ?>
                </div>
                <div class="flex-grow-1">
                    <h2 class="profile-name"><?= htmlspecialchars($_SESSION['username']) ?></h2>
                    <p class="profile-username">@<?= htmlspecialchars(strtolower($_SESSION['username'])) ?></p>
                    <span class="role-badge"><?= htmlspecialchars($_SESSION['role']) ?></span>
                </div>
                <div>
                    <a href="logout.php" class="btn-logout-outline">Logout</a>
                </div>
            </div>
            <div class="profile-divider"></div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="section-label">Account Information</div>
                    <div class="info-row">
                        <span>Username</span>
                        <span><?= htmlspecialchars($_SESSION['username']) ?></span>
                    </div>
                    <div class="info-row">
                        <span>Role</span>
                        <span><?= htmlspecialchars(ucfirst($_SESSION['role'])) ?></span>
                    </div>
                    <div class="info-row">
                        <span>Status</span>
                        <span style="color:#1a7d3a;">Active</span>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="section-label">Quick Actions</div>
                    <div class="row g-3">
                        <?php if ($_SESSION['role'] == 'artist') : ?>
                            <div class="col-md-6">
                                <a href="submit_artwork.php" class="action-card">
                                    <div class="icon-box"><i class="fa fa-plus"></i></div>
                                    <div>
                                        <h6>Submit Artwork</h6>
                                        <p>Add a new piece to your collection</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="my_artworks.php" class="action-card">
                                    <div class="icon-box"><i class="fa fa-image"></i></div>
                                    <div>
                                        <h6>My Artworks</h6>
                                        <p>View and manage your submissions</p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-6">
                            <a href="home.php" class="action-card">
                                <div class="icon-box"><i class="fa fa-th-large"></i></div>
                                <div>
                                    <h6>Browse Artworks</h6>
                                    <p>Explore the gallery collection</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="auction.php" class="action-card">
                                <div class="icon-box"><i class="fa fa-gavel"></i></div>
                                <div>
                                    <h6>Auctions</h6>
                                    <p>See current and upcoming auctions</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 mt-5">
        <div class="container py-4">
            <div class="row g-5">
                <div class="col-lg-12 text-center">
                    <p>&copy; Hiranya Art House. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="assets/lib/lightbox/js/lightbox.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>