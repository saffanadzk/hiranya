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
    <title>Discover | Hiranya House</title>

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
            <h1 class="font-playfair-display mb-2">Discover</h1>
            <p class="discover-sub">Exhibitions, stories, and insights from the world of Hiranya</p>
        </div>
    </div>

    <!-- Featured story -->
    <div class="container py-5">
        <a href="#" class="story-feature">
            <div class="story-feature-img">
                <img src="img/artwork1.jpg" alt="Featured Exhibition">
            </div>
            <div class="story-feature-text">
                <span class="story-tag">EXHIBITION</span>
                <h2>The Rise of Emerging Indonesian Artists</h2>
                <p>An inside look at the new generation reshaping the regional art scene, on view through August 2026 at our Jakarta gallery.</p>
                <span class="story-read-more">READ MORE <i class="bi bi-arrow-right"></i></span>
            </div>
        </a>

        <div class="row g-4 mt-4">

            <div class="col-md-6 col-lg-4">
                <a href="#" class="story-card">
                    <div class="story-card-img">
                        <img src="img/artwork2.jpg" alt="How to Start Collecting Art">
                        <span class="story-tag-overlay">GUIDE</span>
                    </div>
                    <div class="story-card-body">
                        <h6>How to Start Collecting Art</h6>
                        <p>A beginner-friendly guide to building your first collection.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="#" class="story-card">
                    <div class="story-card-img">
                        <img src="img/artwork3.jpg" alt="Inside the Auction Room">
                        <span class="story-tag-overlay">AUCTION HOUSE</span>
                    </div>
                    <div class="story-card-body">
                        <h6>Inside the Auction Room</h6>
                        <p>What really happens behind the gavel during a live sale.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="#" class="story-card">
                    <div class="story-card-img">
                        <img src="img/artwork1.jpg" alt="The Art Market in 2026">
                        <span class="story-tag-overlay">MARKET</span>
                    </div>
                    <div class="story-card-body">
                        <h6>The Art Market in 2026</h6>
                        <p>Key trends shaping prices and demand across the region.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="#" class="story-card">
                    <div class="story-card-img">
                        <img src="img/artwork2.jpg" alt="Conservation Spotlight">
                        <span class="story-tag-overlay">EXHIBITION</span>
                    </div>
                    <div class="story-card-body">
                        <h6>Conservation Spotlight: Old Masters</h6>
                        <p>How our team preserves century-old canvases for future viewing.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="#" class="story-card">
                    <div class="story-card-img">
                        <img src="img/artwork3.jpg" alt="Meet the Curators">
                        <span class="story-tag-overlay">PEOPLE</span>
                    </div>
                    <div class="story-card-body">
                        <h6>Meet the Curators</h6>
                        <p>The team behind Hiranya's most talked-about exhibitions.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-lg-4">
                <a href="#" class="story-card">
                    <div class="story-card-img">
                        <img src="img/artwork1.jpg" alt="Video: Behind the Scenes">
                        <span class="story-tag-overlay">VIDEO</span>
                    </div>
                    <div class="story-card-body">
                        <h6>Behind the Scenes: Installation Day</h6>
                        <p>Watch how a 40-piece exhibition comes together in 48 hours.</p>
                    </div>
                </a>
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