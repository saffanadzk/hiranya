<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>All Artists | Hiranya House</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="assets/img/favicon.ico" rel="icon">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/discover.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>

<body class="discover-page">
    <?php include 'partials/navbar.php'; ?>
    <div class="discover-page-head">
        <div class="container">
            <h1 class="font-playfair-display mb-2">All Artists</h1>
            <p class="discover-sub">Discover the talents represented and curated by Hiranya Art House</p>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <p class="result-count mb-0">128 artists</p>
                <div class="d-flex gap-2">
                    <select class="form-select shelf-select" style="width:auto;">
                        <option>All Categories</option>
                        <option>Contemporary Art</option>
                        <option>Modern Art</option>
                        <option>Sculpture</option>
                    </select>
                    <select class="form-select shelf-select" style="width:auto;">
                        <option>Sort: Most Followed</option>
                        <option>Sort: A&ndash;Z</option>
                        <option>Sort: Newest</option>
                    </select>
                </div>
            </div>
            <div class="shelf-grid">
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork1.jpg" alt="Wayan Putra">
                    </a>
                    <h6 class="shelf-title">Wayan Putra</h6>
                    <p class="shelf-meta">Contemporary Art</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i>
                        <span>32 works</span>
                    </div>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork2.jpg" alt="Raden Saleh Studio">
                    </a>
                    <h6 class="shelf-title">Raden Saleh Studio</h6>
                    <p class="shelf-meta">Old Masters</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <span>18 works</span>
                    </div>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork3.jpg" alt="Citra Dewanti">
                    </a>
                    <h6 class="shelf-title">Citra Dewanti</h6>
                    <p class="shelf-meta">Mixed Media</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="far fa-star"></i>
                        <span>21 works</span>
                    </div>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork1.jpg" alt="Bagus Santosa">
                    </a>
                    <h6 class="shelf-title">Bagus Santosa</h6>
                    <p class="shelf-meta">Sculpture</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-alt"></i><i class="far fa-star"></i>
                        <span>9 works</span>
                    </div>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork2.jpg" alt="Estate Collection">
                    </a>
                    <h6 class="shelf-title">Estate Collection</h6>
                    <p class="shelf-meta">Jewelry &amp; Heritage</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <span>14 works</span>
                    </div>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork3.jpg" alt="Group Collection">
                    </a>
                    <h6 class="shelf-title">Group Collection</h6>
                    <p class="shelf-meta">Modern Art</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
                        <span>27 works</span>
                    </div>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork1.jpg" alt="Private Collection">
                    </a>
                    <h6 class="shelf-title">Private Collection</h6>
                    <p class="shelf-meta">Vintage Timepieces</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                        <span>11 works</span>
                    </div>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="img/artwork2.jpg" alt="Various Artists">
                    </a>
                    <h6 class="shelf-title">Various Artists</h6>
                    <p class="shelf-meta">Oil &amp; Acrylic</p>
                    <div class="shelf-rating">
                        <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="far fa-star"></i>
                        <span>40 works</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn-card-outline" style="display:inline-block; padding: 12px 36px;">LOAD MORE ARTISTS</a>
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

</body>
</html>