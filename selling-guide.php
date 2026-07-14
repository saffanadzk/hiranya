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
    <title>Selling Guide | Hiranya House</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/discover.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@400;500;700&family=Work+Sans:wght@300;400;500&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="discover-page">

    <?php include 'partials/navbar.php'; ?>

    <div class="sg-hero">
        <span class="sg-hero-eyebrow">SELL WITH HIRANYA</span>
        <h1>Selling Guide</h1>
        <p>Everything you need to know about bringing your artwork to the right collectors through Hiranya Art House.</p>
    </div>

    <div class="container py-5">
        <div class="sg-notice mb-5">
            <div class="sg-notice-icon"><i class="fa fa-info-circle"></i></div>
            <div>
                <h5>Primary Requirement: Register as Artist</h5>
                <p>All sales channels in Hiranya — Submit Artwork, Request Valuation, Sell at Auction, or Sell via Private Sales — are only available for accounts registered as <strong>Artist</strong>. If you don't have an Artist account yet, <a href="register.php">register here</a> and select the <strong>"Artist"</strong> role during registration.</p>
            </div>
        </div>

        <h2 class="font-playfair-display mb-2" style="color:#1C2431;">How to Sell at Hiranya</h2>
        <p class="text-muted mb-4" style="font-size:15px;">There are 4 pathways you can choose from based on your needs:</p>

        <div class="sg-steps">
            <div class="sg-step">
                <div class="sg-step-num">1</div>
                <div class="sg-step-content">
                    <h4>Submit Artwork</h4>
                    <p>Upload your artwork along with the title, description, and price you desire. The Hiranya team will review it and provide an Approved or Rejected decision within 3–5 business days. Once approved, your piece will be displayed in the public gallery and can be viewed by collectors.</p>
                    <span class="sg-step-tag">REQUIRED: Artist Account</span>
                    <a href="submit_artwork.php" class="btn btn-sm ms-2" style="background:#1C2431; color:#fff; font-size:12px; letter-spacing:1px;">SUBMIT NOW</a>
                </div>
            </div>

            <div class="sg-step">
                <div class="sg-step-num">2</div>
                <div class="sg-step-content">
                    <h4>Request Valuation</h4>
                    <p>Not sure what the right price is for your artwork? Submit a valuation request to Hiranya's specialist team. We will evaluate the provenance, condition, and current market demand to provide an accurate price estimate — free of charge.</p>
                    <span class="sg-step-tag">REQUIRED: Artist Account</span>
                    <span class="sg-step-tag ms-1" style="background:rgba(28,36,49,0.08); color:#1C2431; border-color:rgba(28,36,49,0.2);">Coming Soon</span>
                </div>
            </div>

            <div class="sg-step">
                <div class="sg-step-num">3</div>
                <div class="sg-step-content">
                    <h4>Sell at Auction</h4>
                    <p>Do you want your artwork to be featured in Hiranya's auctions? The process is as follows: your piece must first be <strong>submitted and approved</strong>, then <strong>purchased by Hiranya</strong> — meaning Hiranya pays you upfront at an agreed price, and then lists it in an auction with a higher selling price. The auction profits belong to Hiranya.</p>
                    <div class="mt-2 p-3 rounded" style="background: rgba(139,0,0,0.05); border-left: 3px solid #8b0000;">
                        <small class="text-danger fw-bold"><i class="fa fa-exclamation-triangle me-1"></i> Important Note:</small>
                        <small class="d-block text-muted mt-1">Artwork cannot directly enter auctions without going through Hiranya's purchase process. This is to maintain quality and collector trust on our platform.</small>
                    </div>
                    <span class="sg-step-tag mt-2 d-inline-block">REQUIRED: Artist Account + Approved + Purchased by Hiranya</span>
                </div>
            </div>

            <div class="sg-step">
                <div class="sg-step-num">4</div>
                <div class="sg-step-content">
                    <h4>Sell via Private Sales</h4>
                    <p>Once your artwork is approved, collectors can directly purchase it through your Artist profile on the "Buy Privately" page — without having to wait for an auction. Collectors pay the price you set, plus a 5% service fee from Hiranya. Payments are sent to the bank account you have registered in your Artist profile.</p>
                    <span class="sg-step-tag">REQUIRED: Artist Account + Approved + Bank Profile Completed</span>
                </div>
            </div>
        </div>

        <h3 class="font-playfair-display mt-5 mb-4" style="color:#1C2431; font-size:22px;">Rules & Important Terms</h3>
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-user-check"></i></div>
                    <h6>Must be Registered as an Artist</h6>
                    <p>Customer accounts cannot submit artwork or make sales. Please re-register as an Artist if you already have a Customer account.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-check-circle"></i></div>
                    <h6>Artwork Must be Approved by Admin</h6>
                    <p>Any submitted artwork will be reviewed. Only artworks with the "Approved" status will be displayed in the gallery and can be sold.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-gavel"></i></div>
                    <h6>Auctions Only Through Hiranya</h6>
                    <p>For artwork to enter auctions, it must first be purchased by Hiranya. Artists cannot directly submit artwork to the auction list.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-percentage"></i></div>
                    <h6>Service Fee 5%</h6>
                    <p>For direct private sales between Artist and Collector, Hiranya takes a 5% commission from the artwork price as platform service fee.</p>
                </div>
            </div>
        </div>

        <div class="sg-cta">
            <h3>Ready to Get Started?</h3>
            <p>Register as an Artist and submit your first artwork today.</p>
            <a href="register.php" class="sg-cta-btn">REGISTER AS ARTIST</a>
        </div>

    </div>

    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 mt-5">
        <div class="container py-4 text-center">
            <p>&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>