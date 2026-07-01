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

    <!-- Page Heading + Sub Tabs -->
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

    <!-- Hero Carousel -->
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
                    <img src="assets/img/artwork2.jpg" alt="Pharaoh's Throne">
                    <div class="carousel-caption-custom">
                        <span class="eyebrow">LIVE AUCTION &middot; 10 JUNE 2027</span>
                        <h2>Pharaoh's Throne &mdash; Bali Pavilion</h2>
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

                <!-- Sidebar Filter: dropdown style -->
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
                                        <input class="form-check-input" type="checkbox" id="evOnline">
                                        <label class="form-check-label" for="evOnline">Online Auctions</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="evLive">
                                        <label class="form-check-label" for="evLive">Live Auctions</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="evOffline">
                                        <label class="form-check-label" for="evOffline">Offline Auctions</label>
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
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="catSculpture">
                                        <label class="form-check-label" for="catSculpture">Sculpture</label>
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
                                        <input class="form-check-input" type="checkbox" id="locSurakarta">
                                        <label class="form-check-label" for="locSurakarta">Surakarta</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Auction Cards -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="result-count mb-0">Showing 6 upcoming auctions</p>
                        <select class="form-select sort-select" style="width:auto;">
                            <option>Sort: Soonest First</option>
                            <option>Sort: Most Lots</option>
                            <option>Sort: A&ndash;Z</option>
                        </select>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="assets/img/artwork6.jpg" alt="Luristan (or Lorestan)">
                                    <span class="tag tag-upcoming">UPCOMING</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Painted Terracotta Vessel with Ibex Motif</h5>
                                    <p class="meta">19 June 2027 &middot; Jakarta</p>
                                    <a href="#" class="btn-card-outline w-100">VIEW LOTS</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="assets/img/artwork5.jpg" alt="Balinese Dancer">
                                    <span class="tag tag-live">LIVE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Balinese Dancer</h5>
                                    <p class="meta">21 December 2026 &middot; 10.00 WIB</p>
                                    <a href="#" class="btn-card-solid w-100">VIEW LOTS</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="assets/img/artwork4.jpg" alt="The Scream">
                                    <span class="tag tag-online">ONLINE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>The Scream</h5>
                                    <p class="meta">6&ndash;10 August 2026 &middot; Online</p>
                                    <a href="#" class="btn-card-outline w-100">BID NOW</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="assets/img/artwork7.jpg" alt="Heritage Jewels">
                                    <span class="tag tag-upcoming">UPCOMING</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>The ancient jewels of Roman women</h5>
                                    <p class="meta">19 June 2027 &middot; Jakarta</p>
                                    <a href="#" class="btn-card-outline w-100">VIEW LOTS</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="assets/img/artwork8.jpg" alt="Watches">
                                    <span class="tag tag-online">ONLINE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Patek Philippe Sky Moon Tourbillon rose gold 6002R</h5>
                                    <p class="meta">1&ndash;5 July 2026 &middot; Online</p>
                                    <a href="#" class="btn-card-outline w-100">BID NOW</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="assets/img/artwork9.jpg" alt="Thunderstruck — Entang Wiharso">
                                    <span class="tag tag-live">LIVE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Thunderstruck — Entang Wiharso</h5>
                                    <p class="meta">28 September 2026 &middot; 23.00 WIB</p>
                                    <a href="#" class="btn-card-solid w-100">VIEW LOTS</a>
                                </div>
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