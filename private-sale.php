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
    <title>Private Sales | Hiranya House</title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="assets/img/favicon.ico" rel="icon">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/auctions.css" rel="stylesheet">
    <link href="assets/css/discover.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>

<body class="discover-page">
    <?php include 'partials/navbar.php'; ?>
    <div class="discover-page-head">
        <div class="container">
            <h1 class="font-playfair-display mb-2">Available Works</h1>
            <p class="discover-sub">Acquire exceptional pieces directly, outside the auction room</p>
            <ul class="auction-subtabs">
                <li><a href="private-sale.php" class="active">Available Works</a></li>
                <li><a href="featured-collections.php">Featured Collections</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">

                <!-- Sidebar Filter -->
                <div class="col-lg-3 mb-4">
                    <div class="filter-panel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="filter-title mb-0">Filter By</h6>
                            <a href="#" class="clear-link">Clear all</a>
                        </div>
                        <div class="filter-dropdown">
                            <button class="filter-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterMedium">
                                MEDIUM <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="collapse show" id="filterMedium">
                                <div class="filter-dropdown-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="medPainting">
                                        <label class="form-check-label" for="medPainting">Painting</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="medSculpture">
                                        <label class="form-check-label" for="medSculpture">Sculpture</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="medJewelry">
                                        <label class="form-check-label" for="medJewelry">Jewelry</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-dropdown">
                            <button class="filter-dropdown-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterPrice">
                                PRICE RANGE <i class="fa fa-chevron-down"></i>
                            </button>
                            <div class="collapse" id="filterPrice">
                                <div class="filter-dropdown-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="priceUnder50">
                                        <label class="form-check-label" for="priceUnder50">Under Rp 50,000,000</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="price50to150">
                                        <label class="form-check-label" for="price50to150">Rp 50,000,000 &ndash; 150,000,000</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="priceAbove150">
                                        <label class="form-check-label" for="priceAbove150">Above Rp 150,000,000</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Works Grid -->
                <div class="col-lg-9">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="result-count mb-0">Showing 6 available works</p>
                        <select class="form-select sort-select" style="width:auto;">
                            <option>Sort: Newest</option>
                            <option>Sort: Price High to Low</option>
                            <option>Sort: Price Low to High</option>
                        </select>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="img/artwork1.jpg" alt="Morning Mist">
                                    <span class="tag tag-upcoming">AVAILABLE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Morning Mist</h5>
                                    <p class="meta">Wayan Putra &middot; Oil on canvas</p>
                                    <p class="meta" style="margin-top:-12px;">Rp 145,000,000</p>
                                    <a href="#" class="btn-card-outline w-100">INQUIRE</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="img/artwork2.jpg" alt="Silent Bay">
                                    <span class="tag tag-upcoming">AVAILABLE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Silent Bay</h5>
                                    <p class="meta">Citra Dewanti &middot; Mixed media</p>
                                    <p class="meta" style="margin-top:-12px;">Rp 78,500,000</p>
                                    <a href="#" class="btn-card-outline w-100">INQUIRE</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="img/artwork3.jpg" alt="Heritage Necklace">
                                    <span class="tag tag-online">JEWELRY</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Heritage Necklace</h5>
                                    <p class="meta">Estate Collection &middot; Gold &amp; gemstone</p>
                                    <p class="meta" style="margin-top:-12px;">Rp 320,000,000</p>
                                    <a href="#" class="btn-card-outline w-100">INQUIRE</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="img/artwork1.jpg" alt="Bronze Figure">
                                    <span class="tag tag-online">SCULPTURE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Bronze Figure No. 4</h5>
                                    <p class="meta">Bagus Santosa &middot; Bronze</p>
                                    <p class="meta" style="margin-top:-12px;">Rp 64,000,000</p>
                                    <a href="#" class="btn-card-outline w-100">INQUIRE</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="img/artwork2.jpg" alt="Twilight Garden">
                                    <span class="tag tag-upcoming">AVAILABLE</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Twilight Garden</h5>
                                    <p class="meta">Raden Saleh Studio &middot; Oil on canvas</p>
                                    <p class="meta" style="margin-top:-12px;">Rp 210,000,000</p>
                                    <a href="#" class="btn-card-outline w-100">INQUIRE</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="auction-card h-100">
                                <div class="auction-card-img">
                                    <img src="img/artwork3.jpg" alt="Vintage Chronograph">
                                    <span class="tag tag-online">WATCH</span>
                                </div>
                                <div class="auction-card-body">
                                    <h5>Vintage Chronograph</h5>
                                    <p class="meta">Private Collection &middot; Stainless steel</p>
                                    <p class="meta" style="margin-top:-12px;">Rp 47,000,000</p>
                                    <a href="#" class="btn-card-outline w-100">INQUIRE</a>
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