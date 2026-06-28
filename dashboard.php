<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';
if(!isset($_SESSION['user_id'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dashboard Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="assets/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<div class="container-fluid bg-light sticky-top p-0">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm py-3 px-4" style="background-color: #1C2431;">
        <a href="dashboard.php" class="navbar-brand me-5">
            <h1 class="mb-0 text-light">Hiranya</h1>
        </a>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto">
                <!-- AUCTIONS -->
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#">AUCTIONS</a>
                    <div class="dropdown-menu border-0 shadow p-4" style="min-width: 700px;">
                        <div class="row">
                            <div class="col-6">
                                <a class="dropdown-item" href="auction.php">CURRENT AUCTIONS</a>
                                <a class="dropdown-item" href="auction.php">UPCOMING AUCTIONS</a>
                                <a class="dropdown-item" href="auction.php">AUCTION RESULTS</a>
                                <a class="dropdown-item" href="auction.php">HOW TO BID</a>
                            </div>
                            <div class="col-6 border-start">
                                <h6 class="text-danger">FEATURED</h6>
                                <p>Featured Auction | Ending Soon | Most Viewed</p>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- PRIVATE SALES -->
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#">PRIVATE SALES</a>
                    <div class="dropdown-menu border-0 shadow p-4" style="min-width: 700px;">
                        <div class="row">
                            <div class="col-4">
                                <h6 class="text-danger">AVAILABLE</h6>
                                <a class="dropdown-item" href="available_works.php">AVAILABLE WORKS</a>
                                <a class="dropdown-item" href="featured_collections.php">FEATURED COLLECTIONS</a>
                            </div>
                            <div class="col-4">
                                <h6 class="text-danger">BUY/SELL</h6>
                                <a class="dropdown-item" href="buy_privately.php">BUY PRIVATELY</a>
                                <a class="dropdown-item" href="sell_privately.php">SELL PRIVATELY</a>
                            </div>
                            <div class="col-4 border-start">
                                <h6 class="text-danger">HIGHLIGHTS</h6>
                                <p>Karya unggulan | Koleksi kurator | Karya baru masuk</p>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- ARTISTS -->
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#">ARTISTS</a>
                    <div class="dropdown-menu border-0 shadow p-4" style="min-width: 600px;">
                        <div class="row">
                            <div class="col-6">
                                <a class="dropdown-item" href="featured_artists.php">FEATURED ARTISTS</a>
                                <a class="dropdown-item" href="emerging_artists.php">EMERGING ARTISTS</a>
                                <a class="dropdown-item" href="all_artists.php">ALL ARTISTS</a>
                                <a class="dropdown-item" href="become_artist.php">BECOME AN ARTIST</a>
                            </div>
                            <div class="col-6 border-start">
                                <h6 class="text-danger">HIGHLIGHTS</h6>
                                <p>Profil seniman pilihan | Karya terbaru mereka</p>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- DISCOVER -->
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#">DISCOVER</a>
                    <div class="dropdown-menu border-0 shadow p-4" style="min-width: 800px;">
                        <div class="row">
                            <div class="col-4">
                                <h6 class="text-danger">EXPLORE</h6>
                                <a class="dropdown-item" href="exhibitions.php">EXHIBITIONS</a>
                                <a class="dropdown-item" href="art_stories.php">ART STORIES</a>
                                <a class="dropdown-item" href="art_market.php">ART MARKET</a>
                            </div>
                            <div class="col-4">
                                <h6 class="text-danger">RESOURCES</h6>
                                <a class="dropdown-item" href="collectors_guide.php">COLLECTOR'S GUIDE</a>
                                <a class="dropdown-item" href="news.php">NEWS</a>
                                <a class="dropdown-item" href="videos.php">VIDEOS</a>
                            </div>
                            <div class="col-4 border-start">
                                <h6 class="text-danger">LATEST STORIES</h6>
                                <small>The Rise of Emerging Indonesian Artists</small><br>
                                <small>How to Start Collecting Art</small>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- SELL WITH US -->
                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#">SELL WITH US</a>
                    <div class="dropdown-menu border-0 shadow p-4" style="min-width: 600px;">
                        <div class="row">
                            <div class="col-6">
                                <a class="dropdown-item" href="submit_artwork.php">
                                    SUBMIT ARTWORK
                                </a>
                                <a class="dropdown-item" href="request_valuation.php">
                                    REQUEST VALUATION
                                </a>
                                <a class="dropdown-item" href="sell_auction.php">
                                    SELL AT AUCTION
                                </a>
                                <a class="dropdown-item" href="sell_private.php">
                                    SELL VIA PRIVATE SALES
                                </a>
                                <a class="dropdown-item" href="selling_guide.php">
                                    SELLING GUIDE
                                </a>
                            </div>
                            <div class="col-6 border-start">
                                <h6 class="text-danger">GUIDANCE</h6>
                                <p>
                                    Get an estimate |
                                    How Hiranya House works |
                                    Success stories
                                </p>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <!-- KANAN NAVBAR -->
            <div class="d-flex align-items-center ms-auto">
                <form class="d-flex align-items-center me-4">
                    <input class="form-control me-2"
                           type="search"
                           placeholder="Search..."
                           style="width:180px;border:none;border-bottom:1px solid #f5f5f5;border-radius:0;box-shadow:none;background:transparent;">
                    <button type="submit" class="btn p-0" style="background:none;border:none;">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                <a href="profile.php" class="text-white me-3">
                    <i class="fa fa-user fa-lg"></i>
                </a>
            </div>
        </div>
    </nav>
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