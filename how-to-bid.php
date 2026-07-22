<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>How to Participate in an Art Auction | Hiranya Art House</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="A comprehensive guide to participating in art auctions at Hiranya Art House.">
    
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css?v=1.3" rel="stylesheet">
    <link href="assets/css/dark_mode.css?v=1.3" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1C2431 0%, #223971 100%) !important;
            color: #D9D4CE !important;
            padding: 80px 0 60px !important;
            border-bottom: 3px solid #AB8E5B !important;
        }
    </style>
</head>
<body class="<?= $theme_class; ?>">

    <?php include 'partials/navbar.php'; ?>

    <div class="hero-section text-center">
        <div class="container py-4">
            <span class="gold-badge mb-3"><i class="fa fa-gavel me-2"></i>Collectors Guide</span>
            <h1 class="fw-semibold text-white mb-3">How to Participate in an Art Auction</h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 580px;">
                Welcome to Hiranya. Follow these 5 simple steps to participate in our exclusive art auctions safety and transparently.
            </p>
        </div>
    </div>

    <div class="container py-5">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark mb-2">5 Easy Steps to Join an Auction</h2>
            <p class="text-muted">A fast and seamless process from placing your first bid to winning your desired artworks.</p>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">1</div>
                        <i class="fa fa-user-plus fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Register & Login</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Create your free Hiranya Art House account or log in to your existing account. Make sure your email address and phone number are verified so you can receive auction updates and winner notifications.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">2</div>
                        <i class="fa fa-compass fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Browse the Auction Catalog</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Navigate to <strong>AUCTIONS &rarr; Current Auctions</strong> to explore a curated selection of exceptional artworks currently open for bidding.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">3</div>
                        <i class="fa fa-clock fa-2x text-danger"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Review Artwork Details & Auction Timer</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Click on your preferred artwork to view its specifications, medium, certificate of authenticity, starting bid, and the live auction countdown timer.
                </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 ms-lg-auto">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">4</div>
                        <i class="fa fa-hand-holding-usd fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Place Your Bid</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Enter your bid amount (it must exceed the current highest bid by at least the minimum bid increment), then click Place Bid. Your bid will be recorded instantly in real time.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 me-lg-auto">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">5</div>
                        <i class="fa fa-trophy fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Win & Complete Your Payment</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                      If you remain the highest bidder when the auction ends, congratulations—you are the winning bidder! Complete your payment via bank transfer within 24 hours to secure your purchase.</p>
                </div>
            </div>

        </div>

        <div class="my-5 p-4 bg-white shadow-sm rounded-4 border-0">
            <h4 class="fw-bold text-dark mb-3"><i class="fa fa-shield-alt text-warning me-2"></i>Important Auction Rules & Terms</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="rule-box h-100">
                        <h6 class="fw-bold text-dark mb-1"><i class="fa fa-check-circle me-2 text-success"></i>Binding Bids</h6>
                        <p class="text-muted small mb-0">
                            Every bid you submit is legally binding. Please review all artwork details carefully before placing a bid.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rule-box h-100">
                        <h6 class="fw-bold text-dark mb-1"><i class="fa fa-clock me-2 text-primary"></i>Automatic Extension (Soft Close)</h6>
                        <p class="text-muted small mb-0">
                            If a new bid is placed during the final 2 minutes of an auction, the countdown timer will automatically extend by 3 minutes to ensure a fair opportunity for all bidders.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5">
            <h3 class="fw-bold text-dark text-center mb-4">Frequently Asked Questions (FAQ)</h3>
            
            <div class="accordion shadow-sm rounded-3 overflow-hidden" id="faqAccordion">
                
                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            What happens if another bidder outbids me?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            If another participant places a higher bid, you will receive a notification in your account. You may submit a higher bid at any time before the auction closes.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Which payment methods are accepted?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            We support official bank transfers (BCA, Bank Mandiri, BNI) and credit cards through Hiranya Art House's verified payment channels.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            How will my artwork be delivered after I win the auction?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Once your payment is verified by our curatorial team, the artwork will be professionally packaged according to museum-grade protection standards and shipped directly to your destination address along with a Certificate of Authenticity.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center my-5 py-4 bg-dark text-white rounded-4 p-4 shadow">
            <h3 class="fw-semibold mb-2">Ready to Expand Your Art Collection?</h3>
            <p class="text-white-50 mb-4">Discover an exceptional selection of carefully curated paintings and masterpieces currently available for auction today.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="auction.php" class="btn btn-warning btn-lg px-4 fw-bold">
                    <i class="fa fa-gavel me-2"></i>Look at Active Auctions
                </a>
                <a href="auction-results.php" class="btn btn-outline-light btn-lg px-4">
                    <i class="fa fa-history me-2"></i>View Past Auction Results
                </a>
            </div>
        </div>

    </div>

    <div class="container-fluid footer bg-dark text-white-50 py-5 mt-5">
        <div class="container py-4 text-center">
            <p class="mb-0">&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
