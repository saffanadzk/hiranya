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
    <title>Auction Results | Hiranya House</title>

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

    <!-- Page Heading + Sub Tabs -->
    <div class="auction-page-head">
        <div class="container">
            <h1 class="font-playfair-display mb-3">Auction Results</h1>
            <ul class="auction-subtabs">
                <li><a href="auction.php">Current</a></li>
                <li><a href="upcoming-auctions.php">Upcoming</a></li>
                <li><a href="auction-results.php" class="active">Results</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">

                <!-- Sidebar Filter: dropdown style -->
                <div class="col-lg-3 mb-4">
                    <div class="filter-panel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="filter-title mb-0">Filter By</h6>
                            <a href="#" class="clear-link">Clear all</a>
                        </div>
                        <div class="filter-dropdown">
                            <button class="filter-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterYear">
                                YEAR <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="collapse show" id="filterYear">
                                <div class="filter-dropdown-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="yr2026">
                                        <label class="form-check-label" for="yr2026">2026</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="yr2025">
                                        <label class="form-check-label" for="yr2025">2025</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="yr2024">
                                        <label class="form-check-label" for="yr2024">2024</label>
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="catContemporary">
                                        <label class="form-check-label" for="catContemporary">Contemporary Art</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="catModern">
                                        <label class="form-check-label" for="catModern">Modern Art</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="catJewelry">
                                        <label class="form-check-label" for="catJewelry">Jewelry</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="catWatches">
                                        <label class="form-check-label" for="catWatches">Watches</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-dropdown">
                            <button class="filter-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterLocation">
                                LOCATION <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="filterLocation">
                                <div class="filter-dropdown-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="locJakarta">
                                        <label class="form-check-label" for="locJakarta">Jakarta</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="locBali">
                                        <label class="form-check-label" for="locBali">Bali</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="locOnline">
                                        <label class="form-check-label" for="locOnline">Online Only</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results List -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="result-count mb-0">Showing 6 past auction results</p>
                        <select class="form-select sort-select" style="width:auto;">
                            <option>Sort: Most Recent</option>
                            <option>Sort: Highest Price</option>
                            <option>Sort: A&ndash;Z</option>
                        </select>
                    </div>
                    <div class="result-list">
                        <div class="result-row">
                            <div class="result-img">
                                <img src="img/artwork1.jpg" alt="Sunset Harmony">
                            </div>
                            <div class="result-info">
                                <span class="result-date">12 May 2026 &middot; Jakarta</span>
                                <h5>Sunset Harmony</h5>
                                <p class="result-artist">Raden Saleh Studio &middot; Oil on canvas</p>
                            </div>
                            <div class="result-price">
                                <span class="price-label">Sold for</span>
                                <span class="price-value">Rp 185,000,000</span>
                                <span class="tag tag-sold">SOLD</span>
                            </div>
                        </div>
                        <div class="result-row">
                            <div class="result-img">
                                <img src="img/artwork2.jpg" alt="Golden Reflection">
                            </div>
                            <div class="result-info">
                                <span class="result-date">28 April 2026 &middot; Bali</span>
                                <h5>Golden Reflection</h5>
                                <p class="result-artist">Wayan Putra &middot; Acrylic on canvas</p>
                            </div>
                            <div class="result-price">
                                <span class="price-label">Sold for</span>
                                <span class="price-value">Rp 92,500,000</span>
                                <span class="tag tag-sold">SOLD</span>
                            </div>
                        </div>
                        <div class="result-row">
                            <div class="result-img">
                                <img src="img/artwork3.jpg" alt="Contemporary Voices">
                            </div>
                            <div class="result-info">
                                <span class="result-date">15 April 2026 &middot; Online</span>
                                <h5>Contemporary Voices</h5>
                                <p class="result-artist">Group Collection &middot; Mixed media</p>
                            </div>
                            <div class="result-price">
                                <span class="price-label">Estimate not met</span>
                                <span class="price-value price-passed">&mdash;</span>
                                <span class="tag tag-passed">PASSED</span>
                            </div>
                        </div>
                        <div class="result-row">
                            <div class="result-img">
                                <img src="img/artwork1.jpg" alt="Heritage Jewels">
                            </div>
                            <div class="result-info">
                                <span class="result-date">2 April 2026 &middot; Jakarta</span>
                                <h5>Heritage Jewels Collection</h5>
                                <p class="result-artist">Estate Collection &middot; Gold &amp; gemstone</p>
                            </div>
                            <div class="result-price">
                                <span class="price-label">Sold for</span>
                                <span class="price-value">Rp 340,000,000</span>
                                <span class="tag tag-sold">SOLD</span>
                            </div>
                        </div>
                        <div class="result-row">
                            <div class="result-img">
                                <img src="img/artwork2.jpg" alt="Watches Through Time">
                            </div>
                            <div class="result-info">
                                <span class="result-date">20 March 2026 &middot; Online</span>
                                <h5>Watches Through Time</h5>
                                <p class="result-artist">Private Collection &middot; Vintage timepieces</p>
                            </div>
                            <div class="result-price">
                                <span class="price-label">Sold for</span>
                                <span class="price-value">Rp 58,000,000</span>
                                <span class="tag tag-sold">SOLD</span>
                            </div>
                        </div>
                        <div class="result-row">
                            <div class="result-img">
                                <img src="img/artwork3.jpg" alt="Modern Masters">
                            </div>
                            <div class="result-info">
                                <span class="result-date">8 March 2026 &middot; Bali</span>
                                <h5>Modern Masters</h5>
                                <p class="result-artist">Various Artists &middot; Oil &amp; acrylic</p>
                            </div>
                            <div class="result-price">
                                <span class="price-label">Sold for</span>
                                <span class="price-value">Rp 127,000,000</span>
                                <span class="tag tag-sold">SOLD</span>
                            </div>
                        </div>

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

</body>
</html>