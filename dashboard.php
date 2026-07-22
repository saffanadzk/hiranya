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
    <link href="assets/css/dark_mode.css" rel="stylesheet">
    <script src="assets/js/theme_toggle.js"></script>
</head>

<body class="<?= $theme_class; ?>">

    <?php include 'partials/navbar.php'; ?>

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
    <!-- Gallery Start -->
    <div class="container-fluid gallery py-5">
        <div class="container">
            <div class="text-center wow fadeIn" data-wow-delay="0.2s">
                <h1 class="font-dancing-script text-primary">Gallery</h1>
                <h1 class="mb-5">Explore Our Collection</h1>
            </div>
            <div class="row g-0">
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.2s">
                    <div class="gallery-item h-100">
                        <img src="assets/img/collection-1.jpg" class="img-fluid w-100 h-100" alt="">
                        <div class="gallery-icon">
                            <a href="assets/img/collection-1.jpg" class="btn btn-primary btn-lg-square"
                                data-lightbox="Collection-1"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 wow fadeIn" data-wow-delay="0.4s">
                    <div class="gallery-item h-100">
                        <img src="assets/img/collection-2.jpg" class="img-fluid w-100 h-100" alt="">
                        <div class="gallery-icon">
                            <a href="assets/img/collection-2.jpg" class="btn btn-primary btn-lg-square"
                                data-lightbox="Collection-2"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 wow fadeIn" data-wow-delay="0.6s">
                    <div class="gallery-item h-100">
                        <img src="assets/img/collection-3.jpg" class="img-fluid w-100 h-100" alt="">
                        <div class="gallery-icon">
                            <a href="assets/img/collection-3.jpg" class="btn btn-primary btn-lg-square"
                                data-lightbox="Collection-3"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 wow fadeIn" data-wow-delay="0.2s">
                    <div class="gallery-item h-100">
                        <img src="assets/img/collection-4.jpg" class="img-fluid w-100 h-100" alt="">
                        <div class="gallery-icon">
                            <a href="assets/img/collection-4.jpg" class="btn btn-primary btn-lg-square"
                                data-lightbox="Collection-4"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 wow fadeIn" data-wow-delay="0.4s">
                    <div class="gallery-item h-100">
                        <img src="assets/img/collection-5.jpg" class="img-fluid w-100 h-100" alt="">
                        <div class="gallery-icon">
                            <a href="assets/img/collection-5.jpg" class="btn btn-primary btn-lg-square"
                                data-lightbox="Collection-5"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 wow fadeIn" data-wow-delay="0.6s">
                    <div class="gallery-item h-100">
                        <img src="assets/img/collection-6.jpg" class="img-fluid w-100 h-100" alt="">
                        <div class="gallery-icon">
                            <a href="assets/img/collection-6.jpg" class="btn btn-primary btn-lg-square"
                                data-lightbox="Collection-6"><i class="fa fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center wow fadeIn" data-wow-delay="0.2s">
                <h1 class="mb-5">Meet Our Experts</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.3s">
                <div class="text-center bg-light p-4">
                    <i class="fa fa-quote-left fa-3x mb-3"></i>
                    <p>Accompanying every collector in discovering the piece that truly speaks to them.
                        Over 15 years spent reading the story behind every brushstroke.</p>
                    <img class="img-fluid mx-auto border p-1 mb-3" src="assets/img/testimonial-1.jpg" alt="">
                    <h4 class="mb-1">Laut Wibisana</h4>
                    <span>Classic Art Collection Companion</span>
                </div>
                <div class="text-center bg-light p-4">
                    <i class="fa fa-quote-left fa-3x mb-3"></i>
                    <p>Guiding you to understand the value and history behind every antique piece of jewelry.
                        Because of us, every gemstone holds a story of its own.</p>
                    <img class="img-fluid mx-auto border p-1 mb-3" src="assets/img/testimonial-2.jpg" alt="">
                    <h4 class="mb-1">Kirana</h4>
                    <span>Antique Jewelry Specialist</span>
                </div>
                <div class="text-center bg-light p-4">
                    <i class="fa fa-quote-left fa-3x mb-3"></i>
                    <p>Helping you preserve the legacy of time, one second at a time. 
                        Every mechanism has a soul, and we're here to keep it alive. 
                    </p>
                    <img class="img-fluid mx-auto border p-1 mb-3" src="assets/img/testimonial-3.jpg" alt="">
                    <h4 class="mb-1">Acil</h4>
                    <span>Horology Expert</span>
                </div>
                <div class="text-center bg-light p-4">
                    <i class="fa fa-quote-left fa-3x mb-3"></i>
                    <p>Connection collectors with history worth preserving. To us, a collection isn't just an 
                        object - it's a memory kept aalive.
                    </p>
                    <img class="img-fluid mx-auto border p-1 mb-3" src="assets/img/testimonial-4.jpg" alt="">
                    <h4 class="mb-1">Eko Isna</h4>
                    <span>Art History Enthusiast</span>
                </div>
            </div>
        </div>
    </div>
   
    <div class="container-fluid blog p-0 mt-5">
        <div class="row g-0">
            <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.1s">
                <div class="h-100 d-flex flex-column justify-content-center bg-primary py-5 px-4">
                    <p 
                        class="fa fa-folder-open text-dark me-1"></i>Collector's Guide</p>
                    <h3 class="mb-3">How to Keep Your Antique Jewelry Shinning</h3>
                    <p>Antique jewelry holds priceless historical value. Learn how to clean and store 
                        your collection so its beauty and value stay preserves for years to come.</p>
                    <a class="btn btn-dark align-self-start text-uppercase" href="">Read More <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.3s">
                <div class="h-100">
                    <img class="img-fluid w-100 h-100" src="assets/img/artikel-1.jpg" alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.5s">
                <div class="h-100 d-flex flex-column justify-content-center bg-primary py-5 px-4">
                    <p class="mb-2"><i class="fa fa-calendar-alt text-dark me-1"></i>Jan 01, 2045 | <i
                            class="fa fa-folder-open text-dark me-1"></i>Auction Trends</p>
                    <h3 class="mb-3">The Most Sought-After Artwork of 2026</h3>
                    <p>From expressionist painting to contemporary installations, discover the types of
                        artwork collectors and investors are chasing most this year.</p>
                    <a class="btn btn-dark align-self-start text-uppercase" href="">Read More <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 wow fadeIn" data-wow-delay="0.7s">
                <div class="h-100">
                    <img class="img-fluid w-100 h-100" src="assets/img/artikel-2.jpg" alt="" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 wow fadeIn" data-wow-delay="0.2s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-6 pe-lg-5">
                    <a href="index.html" class="navbar-brand">
                        <h1 class="display-5 text-primary mb-0"><i class="bi bi-scissors"></i>Hiranya</h1>
                    </a>
                    <p>Aliquyam sed elitr elitr erat sed diam ipsum eirmod eos lorem nonumy. Tempor sea ipsum diam sed
                        clita dolore eos dolores magna erat dolore sed stet justo et dolor.</p>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-2"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-2"></i>+012 345 67890</p>
                    <p><i class="fa fa-envelope me-2"></i>info@example.com</p>
                    <div class="d-flex justify-content-start mt-4">
                        <a class="btn btn-sm-square btn-primary me-3" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-sm-square btn-primary me-3" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-sm-square btn-primary me-3" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-sm-square btn-primary me-3" href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <h5 class="text-primary mb-4">Quick Links</h5>
                            <a class="btn btn-link" href="">About Us</a>
                            <a class="btn btn-link" href="">Contact Us</a>
                            <a class="btn btn-link" href="">Our Services</a>
                            <a class="btn btn-link" href="">Terms & Condition</a>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="text-primary mb-4">Popular Links</h5>
                            <a class="btn btn-link" href="">About Us</a>
                            <a class="btn btn-link" href="">Contact Us</a>
                            <a class="btn btn-link" href="">Our Services</a>
                            <a class="btn btn-link" href="">Terms & Condition</a>
                        </div>
                        <div class="col-sm-12">
                            <h5 class="text-primary mb-4">Newsletter</h5>
                            <div class="position-relative w-100 mb-2">
                                <input class="form-control bg-secondary border-0 w-100 ps-4 pe-5" type="text"
                                    placeholder="Enter Your Email" style="height: 60px;">
                                <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-2 me-2"><i
                                        class="fa fa-paper-plane text-primary fs-4"></i></button>
                            </div>
                            <p class="mb-0">Diam sed sed dolor stet amet eirmod</p>
                        </div>
                    </div>
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