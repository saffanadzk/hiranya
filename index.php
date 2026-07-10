<?php 
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 

    }
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="container-fluid bg-light sticky-top p-0">
        <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm py-3 px-4" style="background-color: #1C2431;">
            <a href="index.php" class="navbar-brand me-5">
                <h1 class="mb-0 text-light"></i>Hiranya</h1>
            </a>
        
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">
                    <!-- 1. AUCTIONS -->
                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">AUCTIONS</a>
                            <div class="dropdown-menu border-0 shadow p-4" style="min-width: 700px;">
                                <div class="row">
                                    <div class="col-6">
                                        <a class="dropdown-item" href="#">CURRENT AUCTIONS</a>
                                        <a class="dropdown-item" href="#">UPCOMING AUCTIONS</a>
                                        <a class="dropdown-item" href="#">AUCTION RESULTS</a>
                                        <a class="dropdown-item" href="#">HOW TO BID</a>
                                    </div>
                                    <div class="col-6 border-start">
                                        <h6 class="text-danger">FEATURED</h6>
                                        <p>Featured Auction | Ending Soon | Most Viewed</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <!-- 2. PRIVATE SALES -->
                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">PRIVATE SALES</a>
                            <div class="dropdown-menu border-0 shadow p-4" style="min-width: 700px;">
                                <div class="row">
                                    <div class="col-4">
                                        <h6 class="text-danger">AVAILABLE</h6>
                                        <a class="dropdown-item" href="#">AVAILABLE WORKS</a>
                                        <a class="dropdown-item" href="#">FEATURED COLLECTIONS</a>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-danger">BUY/SELL</h6>
                                        <a class="dropdown-item" href="#">BUY PRIVATELY</a>
                                    </div>
                                    <div class="col-4 border-start">
                                        <h6 class="text-danger">HIGHLIGHTS</h6>
                                        <p>Karya unggulan | Koleksi kurator | Karya baru masuk</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <!-- 3. ARTISTS -->
                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">ARTISTS</a>
                            <div class="dropdown-menu border-0 shadow p-4" style="min-width: 600px;">
                                <div class="row">
                                    <div class="col-6">
                                        <a class="dropdown-item" href="#">FEATURED ARTISTS</a>
                                        <a class="dropdown-item" href="#">EMERGING ARTISTS</a>
                                        <a class="dropdown-item" href="#">ALL ARTISTS</a>
                                        <a class="dropdown-item" href="#">BECOME AN ARTIST</a>
                                    </div>
                                    <div class="col-6 border-start">
                                        <h6 class="text-danger">HIGHLIGHTS</h6>
                                        <p>Profil seniman pilihan | Karya terbaru mereka</p>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <!-- 4. DISCOVER -->
                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">DISCOVER</a>
                            <div class="dropdown-menu border-0 shadow p-4" style="min-width: 800px;">
                                <div class="row">
                                    <div class="col-4">
                                        <h6 class="text-danger">EXPLORE</h6>
                                        <a class="dropdown-item" href="#">EXHIBITIONS</a>
                                        <a class="dropdown-item" href="#">ART STORIES</a>
                                        <a class="dropdown-item" href="#">ART MARKET</a>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-danger">RESOURCES</h6>
                                        <a class="dropdown-item" href="#">COLLECTOR'S GUIDE</a>
                                        <a class="dropdown-item" href="#">NEWS</a>
                                        <a class="dropdown-item" href="#">VIDEOS</a>
                                    </div>
                                    <div class="col-4 border-start">
                                        <h6 class="text-danger">LATEST STORIES</h6>
                                        <small>The Rise of Emerging Indonesian Artists</small><br>
                                        <small>How to Start Collecting Art</small>
                                    </div>
                                </div>
                            </div>
                        </li>

                    <!-- 5. SELL WITH US -->
                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">SELL WITH US</a>
                            <div class="dropdown-menu border-0 shadow p-4" style="min-width: 600px;">
                                <div class="row">
                                    <div class="col-6">
                                        <a class="dropdown-item" href="#">SUBMIT ARTWORK</a>
                                        <a class="dropdown-item" href="#">REQUEST VALUATION</a>
                                        <a class="dropdown-item" href="#">SELL AT AUCTION</a>
                                        <a class="dropdown-item" href="#">SELL VIA PRIVATE SALES</a>
                                        <a class="dropdown-item" href="#">SELLING GUIDE</a>
                                    </div>
                                    <div class="col-6 border-start">
                                        <h6 class="text-danger">GUIDANCE</h6>
                                        <p>Get an estimate | How Hiranya House works | Success stories</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <!-- KANAN NAVBAR -->
                    <div class="d-flex align-items-center ms-auto">
                        <form class="d-flex align-items-center me-4">
                            <input class="form-control me-2" type="search" placeholder="Search..." aria-label="Search"
                                style="width:180px;border:none;border-bottom:1px solid #f5f5f5;border-radius:0;box-shadow:none;background:transparent;">

                            <button type="submit" class="btn p-0" style="background:none;border:none;">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                            
                        
                             <a href="login.php" class="btn btn-outline-light ms-2 px-4" 
                                style="white-space:nowrap; text-decoration:none;">
                                SIGN IN
                            </a>
                    </div>
                </div>
            </nav>
        
        <div class="container-fluid p-0 hero-header bg-light mb-5">
            <div class="container p-0">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6 hero-header-text py-5">
                        <div class="py-5 px-3 ps-lg-5">
                            <h1 class="font-dancing-script text-primary animated slideInLeft">Welcome</h1>
                            <h1 class="display-6 mb-2 animated slideInLeft font-work-sans">Management System. Manage Gallery Data, Artist, and Collector Information</h1>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="owl-carousel header-carousel animated fadeIn">
                            <img class="img-fluid" src="assets/img/hero-slider-1.jpg." alt="">
                            <img class="img-fluid" src="assets/img/hero-slider-2.jpg.jpg" alt="">
                            <img class="img-fluid" src="assets/img/hero-slider-3.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.2s">
                    <img class="img-fluid mb-3" src="assets/img/bout.jpg" alt="">
                    <div class="d-flex align-items-center bg-light">
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <h1 class="font-dancing-script text-primary">About Us</h1>
                <h1 class="mb-5">Why People Choose Us!</h1>
                <p class="mb-4">Hiranya is an art house dedicated to celebrating creativity 
                    and connecting artists with art enthusiasts.
                    Through curated exhibitions, collection management, and artistic collaborations, 
                    we provide a trusted space where art is discovered, appreciated,
                    and preserved for future generations.</p>
                <div class="row g-4 mb-5">
                    <div class="col-md-3 col-6">
                        <div class="bg-light text-center p-4 h-100">
                            <h1 class="display-4">150+</h1>
                            <p class="text-uppercase mb-0">Artworks Curated</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-light text-center p-4 h-100">
                            <h1 class="display-4">50+</h1>
                            <p class="text-uppercase mb-0">Featured Artists</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-light text-center p-4 h-100">
                            <h1 class="display-4">20+</h1>
                            <p class="text-uppercase mb-0">Exhibitions Held</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="bg-light text-center p-4 h-100">
                            <h1 class="display-4">500+</h1>
                            <p class="text-uppercase mb-0">Registered Collectors</p>
                        </div>
                    </div>
                    <div class="stats-section">
                </div>
            </div>
        </div>
    </div>    
    <!-- About End -->
    
    <!-- Service Start -->
    <div class="container-fluid service py-5">
        <div class="container">
            <div class="text-center wow fadeIn" data-wow-delay="0.1s">
                <h1 class="font-dancing-script text-primary">Our Services</h1>
                <h1 class="mb-5">Explore Our Services</h1>
            </div>
            <div class="row g-4 g-md-0 text-center">
                <div class="col-md-6 col-lg-4">
                    <div class="service-item h-100 p-4 border-bottom border-end wow fadeIn" data-wow-delay="0.1s">
                        <h3 class="mb-3">Art Exhibitions</h3>
                        <p class="mb-3">
                            Curated exhibitions showcasing emerging and established artists,
                            creating meaningful connections between artworks and audiences.
                        </p>
                        <a href="" class="read-more">
                            EXPLORE MORE
                            <span></span><i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-item h-100 p-4 border-bottom border-lg-end wow fadeIn" data-wow-delay="0.3s">
                        <h3 class="mb-3">Artwork Auctions</h3>
                        <p class="mb-3">
                            A trusted platform for collectors to acquire exceptional artworks
                            through transparent and professionally managed auctions.
                        </p>
                        <a href="" class="read-more">
                            EXPLORE MORE
                            <span></span><i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-item h-100 p-4 border-bottom border-end border-lg-end-0 wow fadeIn"
                        data-wow-delay="0.5s">
                        <h3 class="mb-3">Artist Representation</h3>
                        <p class="mb-3">
                            Supporting talented artists through promotion, exhibition opportunities,
                            and long-term professional development.
                        </p>
                        <a href="" class="read-more">
                            EXPLORE MORE
                            <span></span><i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-item h-100 p-4 border-bottom border-lg-bottom-0 border-lg-end wow fadeIn"
                        data-wow-delay="0.1s">
                        <h3 class="mb-3">Art Advisory</h3>
                        <p class="mb-3">
                            Providing professional guidance for collectors and first-time buyers in
                            selecting artworks that align with their interests, spaces, and collecting goals.
                        </p>
                        <a href="" class="read-more">
                            EXPLORE MORE
                            <span></span><i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-item h-100 p-4 border-end wow fadeIn" data-wow-delay="0.3s">
                        <h3 class="mb-3">Artist Development</h3>
                        <p class="mb-3">
                            Supporting artists through exhibitions, promotion, networking opportunities,
                            and long-term career development within the art ecosystem.
                        </p>
                        <a href="" class="read-more">
                            EXPLORE MORE
                            <span></span><i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-item h-100 p-4 wow fadeIn" data-wow-delay="0.5s">
                        <h3 class="mb-3">Art Acquisition</h3>
                        <p class="mb-3">
                            Assisting collectors in discovering and acquiring exceptional artworks
                            through curated selections and personalized recommendations.
                        </p>
                        <a href="" class="read-more">
                            EXPLORE MORE
                            <span></span><i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

        <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
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