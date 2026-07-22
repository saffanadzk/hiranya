<link href="assets/css/dark_mode.css" rel="stylesheet">
<script src="assets/js/theme_toggle.js"></script>

<div class="container-fluid bg-light sticky-top p-0">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm py-3 px-3 px-lg-4" style="background-color: #1C2431;">
        <div class="container-fluid p-0 d-flex align-items-center justify-content-between">
            
            <!-- Brand Logo -->
            <a href="index.php" class="navbar-brand me-3 me-lg-5">
                <h1 class="mb-0 text-light" style="font-family: 'Cinzel', serif; font-weight: 700; font-size: 1.8rem;">Hiranya</h1>
            </a>

            <!-- Mobile Controls (Hamburger & Theme Toggle for Mobile) -->
            <div class="d-flex align-items-center gap-2 d-lg-none">
                <button id="theme-toggle-btn-mobile" onclick="document.getElementById('theme-toggle-btn').click()" class="btn p-0 text-white border-0 bg-transparent me-2" title="Toggle Theme">
                    <i class="fa fa-moon text-warning" style="font-size: 1.25rem;"></i>
                </button>

                <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="register.php" class="btn btn-warning btn-sm fw-bold px-2 py-1 text-dark" style="font-size: 0.75rem;">
                        REGISTER
                    </a>
                <?php endif; ?>

                <button class="navbar-toggler border-0 text-white p-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavbarOffcanvas" aria-controls="mobileNavbarOffcanvas">
                    <i class="fa fa-bars fa-lg"></i>
                </button>
            </div>

            <!-- DESKTOP NAVBAR MENU (Unchanged Layout for Computers) -->
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarCollapse">
                <ul class="navbar-nav mx-auto">

                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">AUCTIONS</a>
                        <div class="dropdown-menu border-0 shadow p-4" style="min-width: 600px;">
                            <div class="row">
                                <div class="col-6">
                                    <a class="dropdown-item" href="auction.php">CURRENT AUCTIONS</a>
                                    <a class="dropdown-item" href="upcoming-auctions.php">UPCOMING AUCTIONS</a>
                                    <a class="dropdown-item" href="auction-results.php">AUCTION RESULTS</a>
                                    <a class="dropdown-item fw-bold text-warning" href="how-to-bid.php"><i class="fa fa-question-circle me-1"></i> HOW TO BID</a>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-danger">FEATURED</h6>
                                    <p class="text-muted small mb-0">Featured Auction | Ending Soon | Most Viewed</p>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">PRIVATE SALES</a>
                        <div class="dropdown-menu border-0 shadow p-4" style="min-width: 600px;">
                            <div class="row">
                                <div class="col-6">
                                    <a class="dropdown-item" href="private-sale.php">AVAILABLE WORKS</a>
                                    <a class="dropdown-item" href="featured-collections.php">FEATURED COLLECTIONS</a>
                                    <a class="dropdown-item" href="artists.php">BUY PRIVATELY</a>
                                    <a class="dropdown-item fw-bold text-warning" href="how-to-buy-privately.php"><i class="fa fa-question-circle me-1"></i> HOW TO BUY PRIVATELY</a>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-danger">HIGHLIGHTS</h6>
                                    <p class="text-muted small mb-0">Featured Artworks | Curator's Collection | New Arrivals</p>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">ARTISTS</a>
                        <div class="dropdown-menu border-0 shadow p-4" style="min-width: 500px;">
                            <div class="row">
                                <div class="col-6">
                                    <a class="dropdown-item" href="artists.php">FEATURED ARTISTS</a>
                                    <a class="dropdown-item" href="artists.php">EMERGING ARTISTS</a>
                                    <a class="dropdown-item" href="artists.php">ALL ARTISTS</a>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-danger">HIGHLIGHTS</h6>
                                    <p class="text-muted small mb-0">Featured Artist Profiles | Their Latest Works</p>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">DISCOVER</a>
                        <div class="dropdown-menu border-0 shadow p-4" style="min-width: 700px;">
                            <div class="row">
                                <div class="col-6">
                                    <h6 class="text-danger">EXPLORE</h6>
                                    <a class="dropdown-item" href="discover.php">EXHIBITIONS</a>
                                    <a class="dropdown-item" href="discover.php">ART STORIES</a>
                                    <a class="dropdown-item" href="discover.php">ART MARKET</a>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-danger">LATEST STORIES</h6>
                                    <small class="text-muted">The Rise of Emerging Indonesian Artists</small><br>
                                    <small class="text-muted">How to Start Collecting Art</small>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-hover">
                        <a class="nav-link dropdown-toggle" href="#">SELL WITH US</a>
                        <div class="dropdown-menu border-0 shadow p-4" style="min-width: 550px;">
                            <div class="row">
                                <div class="col-6">
                                    <a class="dropdown-item" href="submit_artwork.php">SUBMIT ARTWORK</a>
                                    <a class="dropdown-item" href="sell-with-us.php">SELL AT AUCTION</a>
                                    <a class="dropdown-item" href="selling-guide.php">SELLING GUIDE</a>
                                </div>
                                <div class="col-6">
                                    <h6 class="text-danger">GUIDANCE</h6>
                                    <p class="text-muted small mb-0">Get an estimate | How Hiranya House works | Success stories</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <!-- Desktop Action Buttons & Search -->
                <div class="d-flex align-items-center ms-auto">
                    <form action="search.php" method="GET" class="d-flex align-items-center me-3">
                        <input class="form-control me-2"
                               type="search"
                               name="q"
                               placeholder="Search artworks, artists..."
                               value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>"
                               style="width:170px;border:none;border-bottom:1px solid #f5f5f5;border-radius:0;box-shadow:none;background:transparent;color:white;">
                        <button type="submit" class="btn p-0" style="background:none;border:none;color:white;">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span class="text-white-50 me-3 small font-monospace">Hi, @<?= htmlspecialchars($_SESSION['username']); ?></span>
                        <a href="profile.php" class="text-white me-2" title="Profil Saya">
                            <i class="fa fa-user fa-lg"></i>
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-light ms-2 px-3 btn-sm" style="white-space:nowrap; text-decoration:none;">
                            SIGN IN
                        </a>
                        <a href="register.php" class="btn btn-warning ms-2 px-3 btn-sm text-dark fw-bold" style="white-space:nowrap; text-decoration:none;">
                            REGISTER
                        </a>
                    <?php endif; ?>

                    <button id="theme-toggle-btn" class="btn p-0 text-white border-0 bg-transparent ms-3" title="Toggle Theme" style="outline: none; box-shadow: none;">
                        <i class="fa fa-moon" id="theme-toggle-icon" style="font-size: 1.15rem; color: #FBBF24;"></i>
                    </button>
                </div>
            </div>

        </div>
    </nav>
</div>

<!-- MOBILE OFFCANVAS SIDE DRAWER (Menu Samping Khusus HP / Handphone) -->
<div class="offcanvas offcanvas-start text-white d-lg-none" tabindex="-1" id="mobileNavbarOffcanvas" aria-labelledby="mobileNavbarLabel" style="background-color: #1C2431 !important; width: 80%; max-width: 320px;">
    <div class="offcanvas-header border-bottom border-secondary py-3">
        <h5 class="offcanvas-title text-light fw-bold" id="mobileNavbarLabel" style="font-family: 'Cinzel', serif;">Hiranya Art House</h5>
        <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body p-4">
        
        <!-- User Account Box inside Mobile Drawer -->
        <div class="mb-4 pb-3 border-bottom border-secondary">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <small class="text-white-50 d-block">Logged in as</small>
                        <span class="text-warning font-monospace fw-bold">@<?= htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="profile.php" class="btn btn-sm btn-outline-light"><i class="fa fa-user me-1"></i>Profil</a>
                        <a href="logout.php" class="btn btn-sm btn-outline-danger"><i class="fa fa-sign-out-alt"></i></a>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-white-50 small mb-2">Selamat datang! Silakan masuk atau daftar akun baru:</p>
                <div class="d-flex gap-2">
                    <a href="login.php" class="btn btn-outline-light w-50 btn-sm fw-bold">SIGN IN</a>
                    <a href="register.php" class="btn btn-warning w-50 btn-sm fw-bold text-dark">REGISTER</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Search Bar -->
        <form action="search.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="search" name="q" class="form-control bg-dark text-white border-secondary" placeholder="Cari karya seni..." style="font-size: 0.85rem;">
                <button class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>

        <!-- Navigation Links Accordion for Mobile -->
        <div class="accordion accordion-flush" id="mobileMenuAccordion">
            
            <div class="accordion-item bg-transparent border-0 mb-2">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-transparent text-light fw-bold collapsed p-2 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileAuctionsMenu">
                        <i class="fa fa-gavel me-2 text-warning"></i> AUCTIONS
                    </button>
                </h2>
                <div id="mobileAuctionsMenu" class="accordion-collapse collapse" data-bs-parent="#mobileMenuAccordion">
                    <div class="accordion-body py-1 ps-4 d-flex flex-column gap-2">
                        <a href="auction.php" class="text-white-50 text-decoration-none small"><i class="fa fa-angle-right me-1"></i> Current Auctions</a>
                        <a href="upcoming-auctions.php" class="text-white-50 text-decoration-none small"><i class="fa fa-angle-right me-1"></i> Upcoming Auctions</a>
                        <a href="auction-results.php" class="text-white-50 text-decoration-none small"><i class="fa fa-angle-right me-1"></i> Auction Results</a>
                        <a href="how-to-bid.php" class="text-warning fw-bold text-decoration-none small"><i class="fa fa-question-circle me-1"></i> How to Bid</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item bg-transparent border-0 mb-2">
                <h2 class="accordion-header">
                    <button class="accordion-button bg-transparent text-light fw-bold collapsed p-2 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobilePrivateMenu">
                        <i class="fa fa-gem me-2 text-warning"></i> PRIVATE SALES
                    </button>
                </h2>
                <div id="mobilePrivateMenu" class="accordion-collapse collapse" data-bs-parent="#mobileMenuAccordion">
                    <div class="accordion-body py-1 ps-4 d-flex flex-column gap-2">
                        <a href="private-sale.php" class="text-white-50 text-decoration-none small"><i class="fa fa-angle-right me-1"></i> Available Works</a>
                        <a href="featured-collections.php" class="text-white-50 text-decoration-none small"><i class="fa fa-angle-right me-1"></i> Featured Collections</a>
                        <a href="artists.php" class="text-white-50 text-decoration-none small"><i class="fa fa-angle-right me-1"></i> Buy Privately</a>
                        <a href="how-to-buy-privately.php" class="text-warning fw-bold text-decoration-none small"><i class="fa fa-question-circle me-1"></i> How to Buy Privately</a>
                    </div>
                </div>
            </div>

            <div class="accordion-item bg-transparent border-0 mb-2">
                <h2 class="accordion-header">
                    <a href="artists.php" class="nav-link text-light fw-bold p-2">
                        <i class="fa fa-paint-brush me-2 text-warning"></i> ARTISTS
                    </a>
                </h2>
            </div>

            <div class="accordion-item bg-transparent border-0 mb-2">
                <h2 class="accordion-header">
                    <a href="discover.php" class="nav-link text-light fw-bold p-2">
                        <i class="fa fa-compass me-2 text-warning"></i> DISCOVER
                    </a>
                </h2>
            </div>

            <div class="accordion-item bg-transparent border-0 mb-2">
                <h2 class="accordion-header">
                    <a href="sell-with-us.php" class="nav-link text-light fw-bold p-2">
                        <i class="fa fa-store me-2 text-warning"></i> SELL WITH US
                    </a>
                </h2>
            </div>

        </div>

    </div>
</div>

<?php if (isset($_SESSION['message'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            title: '<?= htmlspecialchars($_SESSION['message_type'] == 'success' ? 'Success' : 'Notification'); ?>',
            text: '<?= htmlspecialchars($_SESSION['message']); ?>',
            icon: '<?= $_SESSION['message_type'] == 'danger' ? 'error' : ($_SESSION['message_type'] == 'success' ? 'success' : 'info'); ?>',
            confirmButtonColor: '#ab8e5b'
        });
    });
    </script>
    <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
<?php endif; ?>