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
    <title>Sell With Us | Hiranya House</title>

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
            <h1 class="font-playfair-display mb-2">Sell With Us</h1>
            <p class="discover-sub">Three ways to bring your artwork to the right collectors</p>
        </div>
    </div>

    <div class="container py-5">

        <div id="submit-artwork" class="sell-section row align-items-center g-5">
            <div class="col-lg-6">
                <span class="sell-step">STEP 01</span>
                <h2 class="font-playfair-display">Submit Artwork</h2>
                <p>Tell us about the piece you'd like to sell. Our specialists review every
                    submission and respond within 3&ndash;5 business days with next steps.</p>
                <a href="submit_artwork.php" class="btn-card-solid" style="display:inline-block; padding:14px 32px;">START SUBMISSION</a>
            </div>
            <div class="col-lg-6">
                <img src="img/artwork1.jpg" class="sell-section-img" alt="Submit Artwork">
            </div>
        </div>

        <hr class="sell-divider">

        <div id="request-valuation" class="sell-section row align-items-center g-5 flex-lg-row-reverse">
            <div class="col-lg-6">
                <span class="sell-step">STEP 02</span>
                <h2 class="font-playfair-display">Request a Valuation</h2>
                <p>Not sure what your piece is worth? Our appraisers provide a complimentary
                    estimate based on provenance, condition, and current market demand.</p>
                <a href="#" class="btn-card-outline" style="display:inline-block; padding:14px 32px;">REQUEST VALUATION</a>
            </div>
            <div class="col-lg-6">
                <img src="img/artwork2.jpg" class="sell-section-img" alt="Request Valuation">
            </div>
        </div>

        <hr class="sell-divider">

        <div id="sell-at-auction" class="sell-section row align-items-center g-5">
            <div class="col-lg-6">
                <span class="sell-step">STEP 03</span>
                <h2 class="font-playfair-display">Sell at Auction</h2>
                <p>Once accepted, your piece is placed in an upcoming sale matched to the right
                    audience of collectors, with full marketing and a dedicated specialist.</p>
                <a href="upcoming-auctions.php" class="btn-card-solid" style="display:inline-block; padding:14px 32px;">VIEW UPCOMING SALES</a>
            </div>
            <div class="col-lg-6">
                <img src="img/artwork3.jpg" class="sell-section-img" alt="Sell at Auction">
            </div>
        </div>

        <div class="text-center mt-5 pt-4">
            <span class="sell-step">SUCCESS STORIES</span>
            <h2 class="font-playfair-display mb-4">Trusted by Artists and Collectors</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-box">
                    <p>&ldquo;The valuation process was transparent and the final sale exceeded my estimate.&rdquo;</p>
                    <span>&mdash; Wayan Putra, Artist</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-box">
                    <p>&ldquo;From submission to sale, the Hiranya team handled everything with care.&rdquo;</p>
                    <span>&mdash; Estate Collection, Seller</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-box">
                    <p>&ldquo;A trustworthy partner for placing heritage pieces with serious collectors.&rdquo;</p>
                    <span>&mdash; Private Collection, Seller</span>
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