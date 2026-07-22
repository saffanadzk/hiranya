<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>How to Buy Privately from represented Artists | Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="A step-by-step guide to acquiring artworks directly from artists on Hiranya.">
    
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
        .step-card {
            background-color: #F8F6F2 !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03) !important;
            transition: transform 0.3s ease;
        }
        .step-card:hover {
            transform: translateY(-5px);
        }
        .step-number {
            width: 50px;
            height: 50px;
            background-color: #1C2431;
            color: #AB8E5B;
            font-weight: 800;
            font-size: 1.3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #AB8E5B;
        }
        .rule-box {
            background-color: rgba(171, 142, 91, 0.05) !important;
            border: none !important;
        }
        /* Dark mode compatibility */
        .dark-mode .step-card {
            background-color: #1E293B !important;
            color: #F8FAFC !important;
        }
        .dark-mode .step-number {
            background-color: #0F172A !important;
        }
        .dark-mode .rule-box {
            background-color: rgba(171, 142, 91, 0.12) !important;
        }
    </style>
</head>
<body class="<?= $theme_class; ?>">

    <?php include 'partials/navbar.php'; ?>

    <div class="hero-section text-center">
        <div class="container py-4">
            <span class="gold-badge mb-3"><i class="fa fa-gem me-2"></i>Private Acquisition</span>
            <h1 class="fw-semibold text-white mb-3">How to Buy Directly from Artists</h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
                Learn how to securely acquire exclusive masterpieces directly from represented artists outside the auction room.
            </p>
        </div>
    </div>

    <div class="container py-5">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark mb-2">5 Steps to Private Art Acquisition</h2>
            <p class="text-muted">A direct, secure, and personal connection between collectors and artists.</p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">1</div>
                        <i class="fa fa-compass fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Explore Available Artworks</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Go to the <strong>PRIVATE SALES &rarr; Available Works</strong> catalog to find paintings and masterpieces that are currently offered for direct purchase.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">2</div>
                        <i class="fa fa-user-circle fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Visit Artist's Profile</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Or select <strong>Buy Privately</strong> to meet our represented artists. Click on any artist's profile to view their custom dashboard, verified achievements, and private collection options.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">3</div>
                        <i class="fa fa-shopping-bag fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Acquire Directly</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        On your chosen artwork's detail page, review its specifications, dimensions, and certificate details. Click <strong>Acquire Artwork</strong> to proceed to the secure checkout page.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">4</div>
                        <i class="fa fa-university fa-2x text-danger"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Transfer to Artist's Bank</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        During checkout, the system will securely display the verified bank account details of the artist. You transfer the artwork price directly to the artist's account.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">5</div>
                        <i class="fa fa-check-circle fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Submit Proof & Receive Artwork</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Upload your transfer receipt. Once verified, Hiranya coordinates with the artist to carefully deliver the artwork directly to your destination.
                    </p>
                </div>
            </div>

        </div>

        <div class="my-5 p-4 rule-box rounded-4">
            <h4 class="fw-bold text-dark mb-3"><i class="fa fa-shield-alt text-warning me-2"></i>Hiranya Private Sale Policy</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <i class="fa fa-check text-success mt-1"></i>
                        <p class="text-muted small mb-0"><strong>Direct Price:</strong> All private sale prices are set directly by the artists themselves. There is no bidding or price escalation involved.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <i class="fa fa-check text-success mt-1"></i>
                        <p class="text-muted small mb-0"><strong>Platform Commission:</strong> A minimal 5% platform commission is collected by Hiranya Art House for escrow coordination, security validation, and authenticity checks.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center my-5 py-4 bg-dark text-white rounded-4 p-4 shadow">
            <h3 class="fw-semibold mb-2">Explore the Artists Behind the Masterpieces</h3>
            <p class="text-white-50 mb-4">Connect directly with creators, view their private catalogs, and acquire exclusive paintings today.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="artists.php" class="btn btn-warning btn-lg px-4 fw-bold">
                    <i class="fa fa-palette me-2"></i>Meet represented Artists
                </a>
                <a href="private-sale.php" class="btn btn-outline-light btn-lg px-4">
                    Browse Private Artworks
                </a>
            </div>
        </div>

    </div>

    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5">
        <div class="container py-4 text-center">
            <p>&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
