<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$now = date('Y-m-d H:i:s');
$auc_sql = "
    SELECT auctions.*, artworks.title AS art_title, artworks.image_url, users.username AS artist_name, categories.name AS category_name, categories.slug AS category_slug
    FROM auctions
    JOIN artworks ON auctions.artwork_id = artworks.id
    LEFT JOIN users ON artworks.artist_id = users.id
    LEFT JOIN categories ON artworks.category_id = categories.id
    WHERE auctions.start_time > '$now'
    ORDER BY auctions.start_time ASC
";
$auc_res = mysqli_query($conn, $auc_sql);
$auc_count = mysqli_num_rows($auc_res);

$cat_query = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
$categories = [];
while ($row = mysqli_fetch_assoc($cat_query)) {
    $categories[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Upcoming Auctions | Hiranya </title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="img/favicon.ico" rel="icon">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/auctions.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>

<body class="auction-page">

    <?php include 'partials/navbar.php'; ?>

    <div class="auction-page-head">
        <div class="container">
            <h1 class="font-playfair-display mb-3">Upcoming Auctions</h1>
            <ul class="auction-subtabs">
                <li><a href="auction.php">Current</a></li>
                <li><a href="upcoming-auctions.php" class="active">Upcoming</a></li>
                <li><a href="auction-results.php">Results</a></li>
            </ul>
        </div>
    </div>

    <div class="auction-hero-carousel">
        <div id="auctionCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/artwork1.jpg" alt="Ibuku">
                    <div class="carousel-caption-custom">
                        <span class="eyebrow">UPCOMING AUCTION &middot; 15&ndash;25 December 2026</span>
                        <h2>Ibuku: The Surakarta Sale</h2>
                        <a href="#" class="btn-outline-cream">Browse All Lots</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/artwork22.jpg" alt="Red Bull RB4 Donington Collection 2012">
                    <div class="carousel-caption-custom">
                        <span class="eyebrow">ONLINE AUCTION &middot; 10 JUNE 2027</span>
                        <h2>Red Bull RB4 Donington Collection 2012 &mdash; Bali Pavilion</h2>
                        <a href="#" class="btn-outline-cream">View Lots</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="assets/img/artwork3.jpg" alt="Persistence of Memory">
                    <div class="carousel-caption-custom">
                        <span class="eyebrow">ONLINE AUCTION &middot; 1&ndash;14 AUGUST 2026</span>
                        <h2>Salvador Dalí - The Persistence of Memory </h2>
                        <a href="#" class="btn-outline-cream">Explore Sale</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#auctionCarousel" data-bs-slide="prev">
                <span class="carousel-arrow"><i class="fa fa-chevron-left"></i></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#auctionCarousel" data-bs-slide="next">
                <span class="carousel-arrow"><i class="fa fa-chevron-right"></i></span>
            </button>
            <div class="carousel-indicators-custom">
                <button type="button" data-bs-target="#auctionCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#auctionCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#auctionCarousel" data-bs-slide-to="2"></button>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 mb-4">
                    <div class="filter-panel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="filter-title mb-0">Filter By</h6>
                            <a href="#" class="clear-link">Clear all</a>
                        </div>

                        <div class="filter-dropdown">
                            <button class="filter-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterEvents">
                                EVENTS <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="collapse show" id="filterEvents">
                                <div class="filter-dropdown-body">
                                    <div class="form-check">
                                        <input class="form-check-input filter-type-chk" type="checkbox" value="online" id="evOnline">
                                        <label class="form-check-label" for="evOnline">Online Auctions</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input filter-type-chk" type="checkbox" value="live" id="evLive">
                                        <label class="form-check-label" for="evLive">Live Auctions</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-dropdown">
                            <button class="filter-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterCategory">
                                CATEGORY <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="filterCategory">
                                <div class="filter-dropdown-body">
                                    <?php if (empty($categories)): ?>
                                        <small class="text-muted">No categories</small>
                                    <?php else: ?>
                                        <?php foreach ($categories as $cat): ?>
                                            <div class="form-check">
                                                <input class="form-check-input filter-category-chk" type="checkbox" value="<?= htmlspecialchars($cat['slug']); ?>" id="cat<?= $cat['id']; ?>">
                                                <label class="form-check-label" for="cat<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="result-count mb-0">Showing <?= $auc_count; ?> upcoming auction(s)</p>
                    </div>

                    <div class="row g-4">
                        <?php if ($auc_count === 0): ?>
                            <div class="col-12 text-center py-5">
                                <i class="fa fa-gavel fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No upcoming auctions at the moment.</p>
                            </div>
                        <?php else: ?>
                            <?php while ($auc = mysqli_fetch_assoc($auc_res)): ?>
                                <div class="col-md-6 col-lg-4 auction-item-card" data-type="<?= htmlspecialchars(strtolower($auc['auction_type'])); ?>" data-category="<?= htmlspecialchars($auc['category_slug'] ?? ''); ?>">
                                    <div class="auction-card h-100 d-flex flex-column justify-content-between">
                                        <div class="auction-card-img" style="height: 220px; overflow: hidden; background: #eee;">
                                            <img src="uploads/<?= htmlspecialchars($auc['image_url']); ?>" alt="<?= htmlspecialchars($auc['art_title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                            <?php if (strtoupper($auc['auction_type']) === 'LIVE'): ?>
                                                <span class="tag tag-live">LIVE</span>
                                            <?php else: ?>
                                                <span class="tag tag-upcoming">ONLINE</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="auction-card-body d-flex flex-column justify-content-between flex-grow-1">
                                            <div>
                                                <h5 style="font-family: 'Playfair Display', serif; font-weight: 600; font-size: 16px; margin-bottom: 8px; color: #1C2431;"><?= htmlspecialchars($auc['art_title']); ?></h5>
                                                <p class="meta" style="font-size: 12px; color: #777;">by @<?= htmlspecialchars($auc['artist_name']); ?> &middot; <?= htmlspecialchars($auc['category_name'] ?? 'Uncategorized'); ?></p>
                                                <p class="meta mb-2" style="font-weight: bold; color: #ab8e5b; font-size: 14px;">
                                                    Starting Price: Rp <?= number_format($auc['start_bid'], 0, ',', '.'); ?>
                                                </p>
                                                <p class="small text-danger mb-3" style="font-size: 12px;">
                                                    <i class="fa fa-clock me-1"></i> Starts: <span><?= date('d M Y H:i', strtotime($auc['start_time'])); ?></span>
                                                </p>
                                            </div>
                                            <a href="bidding.php?id=<?= $auc['artwork_id']; ?>" class="btn-card-outline w-100 text-center py-2" style="font-size: 12px; font-weight: 600; letter-spacing: 1px;">VIEW LOTS</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5">
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const typeChecks = document.querySelectorAll(".filter-type-chk");
        const catChecks = document.querySelectorAll(".filter-category-chk");
        const cards = document.querySelectorAll(".auction-item-card");
        const clearLink = document.querySelector(".clear-link");

        function filterItems() {
            const activeTypes = Array.from(typeChecks).filter(chk => chk.checked).map(chk => chk.value);
            const activeCats = Array.from(catChecks).filter(chk => chk.checked).map(chk => chk.value);

            cards.forEach(card => {
                const cardType = card.getAttribute("data-type");
                const cardCat = card.getAttribute("data-category");

                const typeMatch = activeTypes.length === 0 || activeTypes.includes(cardType);
                const catMatch = activeCats.length === 0 || activeCats.includes(cardCat);

                if (typeMatch && catMatch) {
                    card.classList.remove("d-none");
                } else {
                    card.classList.add("d-none");
                }
            });
        }

        typeChecks.forEach(chk => chk.addEventListener("change", filterItems));
        catChecks.forEach(chk => chk.addEventListener("change", filterItems));

        if (clearLink) {
            clearLink.addEventListener("click", function(e) {
                e.preventDefault();
                typeChecks.forEach(chk => chk.checked = false);
                catChecks.forEach(chk => chk.checked = false);
                filterItems();
            });
        }
    });
    </script>
</body>
</html>