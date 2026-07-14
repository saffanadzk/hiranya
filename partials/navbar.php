<div class="container-fluid bg-light sticky-top p-0">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm py-3 px-4" style="background-color: #1C2431;">
        <a href="index.php" class="navbar-brand me-5">
            <h1 class="mb-0 text-light">Hiranya</h1>
        </a>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto">

                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#">AUCTIONS</a>
                    <div class="dropdown-menu border-0 shadow p-4" style="min-width: 700px;">
                        <div class="row">
                            <div class="col-6">
                                <a class="dropdown-item" href="auction.php">CURRENT AUCTIONS</a>
                                <a class="dropdown-item" href="upcoming-auctions.php">UPCOMING AUCTIONS</a>
                                <a class="dropdown-item" href="auction-results.php">AUCTION RESULTS</a>
                                <a class="dropdown-item" href="how-to-bid.php">HOW TO BID</a>
                            </div>
                            <div class="col-6 border-start">
                                    <h6 class="text-danger">FEATURED</h6>
                                    <p>Featured Auction | Ending Soon | Most Viewed</p>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown dropdown-hover">
                    <a class="nav-link dropdown-toggle" href="#">PRIVATE SALES</a>
                    <div class="dropdown-menu border-0 shadow p-4" style="min-width: 700px;">
                        <div class="row">
                            <div class="col-4">
                                <a class="dropdown-item" href="private-sale.php">AVAILABLE WORKS</a>
                                <a class="dropdown-item" href="featured-collections.php">FEATURED COLLECTIONS</a>
                            </div>
                            <div class="col-4">
                                    <h6 class="text-danger">BUY/SELL</h6>
                                    <a class="dropdown-item" href="#">BUY PRIVATELY</a>
                                </div>
                                <div class="col-4 border-start">
                                    <h6 class="text-danger">HIGHLIGHTS</h6>
                                    <p>Featured Artworks | Curator's Collection | New Arrivals</p>
                                </div>
                        </div>
                    </div>
                </li>

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
                                    <p>Featured Artist Profiles | Their Latest Works</p>
                            </div>
                        </div>
                    </div>
                </li>

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
                                    <h6 class="text-danger">LATEST STORIES</h6>                                        <small>The Rise of Emerging Indonesian Artists</small><br>
                                    <small>How to Start Collecting Art</small>
                                </div>
                            </div>
                        </div>
                    </li>

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

            <div class="d-flex align-items-center ms-auto">
                <form action="search.php" method="GET" class="d-flex align-items-center me-4">
                    <input class="form-control me-2"
                           type="search"
                           name="q"
                           placeholder="Search artworks, artists..."
                           value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>"
                           style="width:180px;border:none;border-bottom:1px solid #f5f5f5;border-radius:0;box-shadow:none;background:transparent;color:white;">
                    <button type="submit" class="btn p-0" style="background:none;border:none;color:white;">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="text-white-50 me-3 small font-monospace">Hi, @<?= htmlspecialchars($_SESSION['username']); ?></span>
                <?php endif; ?>
                <a href="profile.php" class="text-white me-3">
                    <i class="fa fa-user fa-lg"></i>
                </a>
            </div>
        </div>
    </nav>
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