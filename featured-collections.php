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
    <title>Featured Collections | Hiranya House</title>

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
            <h1 class="font-playfair-display mb-2">Featured Collections</h1>
            <p class="discover-sub">Curated groupings of available works, handpicked by our specialists</p>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <p class="result-count mb-0">9 collections</p>
                <select class="form-select shelf-select" style="width:auto;">
                    <option>Sort: Newest</option>
                    <option>Sort: Most Works</option>
                    <option>Sort: A&ndash;Z</option>
                </select>
            </div>
            <div class="shelf-grid">
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="assets/img/sold3.jpg" alt="Salvador Mundi">
                    </a>
                    <h6 class="shelf-title">Salvador Mundi - Leonardo Da Vinci</h6>
                    <p class="shelf-meta">32RB works</p>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="assets/img/fear2.jpg" alt="Meiji Period Art">
                    </a>
                    <h6 class="shelf-title">A Cloisonné Vase , Mark of the Hayashi Kodenji Workshop, Meiji Period (Late 19TH Century)</h6>
                    <p class="shelf-meta">30RB works</p>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="assets/img/fear3.jpg" alt="Jewelry Collection">
                    </a>
                    <h6 class="shelf-title">Bulgari Eden The Garden Of Wonders</h6>
                    <p class="shelf-meta">36JT works</p>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="assets/img/fear4.jpg" alt="Contemporary Art">
                    </a>
                    <h6 class="shelf-title">Street Vendors - Sudjana Kerton</h6>
                    <p class="shelf-meta">34JT works</p>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="assets/img/fear5.jpg" alt="Sculpture Collection">
                    </a>
                    <h6 class="shelf-title">Steampunk Animal Sculptures Made Of Scrap Metal - Hasan Novrozi</h6>
                    <p class="shelf-meta">26RB works</p>
                </div>
                <div class="shelf-item">
                    <a href="#" class="shelf-cover">
                        <img src="assets/img/fear6.jpg" alt="Jewelry Collection">
                    </a>
                    <h6 class="shelf-title">Cartier Unveils Four Maria Felix High-Jeweled Crocodile Masterpieces With Rare Colombian Emeralds</h6>
                    <p class="shelf-meta">19JT works</p>
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

</body>
</html>