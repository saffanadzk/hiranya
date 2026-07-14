<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$art_sql = "
    SELECT artworks.*, users.username AS artist_name, categories.name AS category_name, categories.slug AS category_slug
    FROM artworks
    LEFT JOIN users ON artworks.artist_id = users.id
    LEFT JOIN categories ON artworks.category_id = categories.id
    WHERE artworks.is_purchased_by_hiranya = 1 AND artworks.status = 'available'
    ORDER BY artworks.id DESC
";
$art_res = mysqli_query($conn, $art_sql);
$art_count = mysqli_num_rows($art_res);

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
    <title>Private Sales | Hiranya House</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="assets/img/favicon.ico" rel="icon">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/auctions.css" rel="stylesheet">
    <link href="assets/css/discover.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>

<body class="discover-page">
    <?php include 'partials/navbar.php'; ?>
    <div class="discover-page-head">
        <div class="container">
            <h1 class="font-playfair-display mb-2">Available Works</h1>
            <p class="discover-sub">Acquire exceptional pieces directly, outside the auction room</p>
            <ul class="auction-subtabs">
                <li><a href="private-sale.php" class="active">Available Works</a></li>
                <li><a href="featured-collections.php">Featured Collections</a></li>
            </ul>
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
                        <div class="filter-dropdown">
                            <button class="filter-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterPrice">
                                PRICE RANGE <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="filterPrice">
                                <div class="filter-dropdown-body">
                                    <div class="form-check">
                                        <input class="form-check-input filter-price-chk" type="checkbox" value="under50" id="priceUnder50">
                                        <label class="form-check-label" for="priceUnder50">Under Rp 50,000,000</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input filter-price-chk" type="checkbox" value="50to150" id="price50to150">
                                        <label class="form-check-label" for="price50to150">Rp 50,000,000 &ndash; 150,000,000</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input filter-price-chk" type="checkbox" value="above150" id="priceAbove150">
                                        <label class="form-check-label" for="priceAbove150">Above Rp 150,000,000</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="result-count mb-0">Showing <?= $art_count; ?> available work(s)</p>
                    </div>
                    <div class="row g-4">
                        <?php if ($art_count === 0): ?>
                            <div class="col-12 text-center py-5">
                                <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No artworks available for private sale at the moment.</p>
                            </div>
                        <?php else: ?>
                            <?php while ($art = mysqli_fetch_assoc($art_res)): ?>
                                <div class="col-md-6 col-lg-4 private-sale-item-card" data-price="<?= $art['price']; ?>" data-category="<?= htmlspecialchars($art['category_slug'] ?? ''); ?>">
                                    <div class="auction-card h-100">
                                        <div class="auction-card-img" style="height: 220px; overflow: hidden; background: #eee;">
                                            <img src="uploads/<?= htmlspecialchars($art['image_url']); ?>" alt="<?= htmlspecialchars($art['title']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                            <span class="tag tag-upcoming">AVAILABLE</span>
                                        </div>
                                        <div class="auction-card-body">
                                            <h5 style="font-family: 'Playfair Display', serif; font-weight: 600;"><?= htmlspecialchars($art['title']); ?></h5>
                                            <p class="meta">by <?= htmlspecialchars($art['artist_name']); ?> &middot; <?= htmlspecialchars($art['category_name'] ?? 'Uncategorized'); ?></p>
                                            <p class="meta" style="margin-top:-12px; font-weight: bold; color: #ab8e5b;">Rp <?= number_format($art['price'], 0, ',', '.'); ?></p>
                                            <a href="checkout.php?artwork_id=<?= $art['id']; ?>" class="btn-card-outline w-100 text-center">Acquire Artwork</a>
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
        const catChecks = document.querySelectorAll(".filter-category-chk");
        const priceChecks = document.querySelectorAll(".filter-price-chk");
        const cards = document.querySelectorAll(".private-sale-item-card");
        const clearLink = document.querySelector(".clear-link");

        function filterItems() {
            const activeCats = Array.from(catChecks).filter(chk => chk.checked).map(chk => chk.value);
            const activePriceRanges = Array.from(priceChecks).filter(chk => chk.checked).map(chk => chk.value);

            cards.forEach(card => {
                const cardCat = card.getAttribute("data-category");
                const cardPrice = parseFloat(card.getAttribute("data-price"));

                const catMatch = activeCats.length === 0 || activeCats.includes(cardCat);
                
                let priceMatch = activePriceRanges.length === 0;
                if (activePriceRanges.length > 0) {
                    activePriceRanges.forEach(range => {
                        if (range === "under50" && cardPrice < 50000000) priceMatch = true;
                        if (range === "50to150" && cardPrice >= 50000000 && cardPrice <= 150000000) priceMatch = true;
                        if (range === "above150" && cardPrice > 150000000) priceMatch = true;
                    });
                }

                if (catMatch && priceMatch) {
                    card.classList.remove("d-none");
                } else {
                    card.classList.add("d-none");
                }
            });
        }

        catChecks.forEach(chk => chk.addEventListener("change", filterItems));
        priceChecks.forEach(chk => chk.addEventListener("change", filterItems));

        if (clearLink) {
            clearLink.addEventListener("click", function(e) {
                e.preventDefault();
                catChecks.forEach(chk => chk.checked = false);
                priceChecks.forEach(chk => chk.checked = false);
                filterItems();
            });
        }
    });
    </script>
</body>
</html>