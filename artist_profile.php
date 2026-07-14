<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$artist_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($artist_id <= 0) {
    die("Artist ID tidak valid!");
}

$user_query = mysqli_query($conn, "SELECT username, email FROM users WHERE id = $artist_id AND role_id = 2");
if (mysqli_num_rows($user_query) === 0) {
    die("Artist tidak ditemukan atau user ini bukan seniman.");
}
$artist_user = mysqli_fetch_assoc($user_query);

$profile_query = mysqli_query($conn, "SELECT * FROM artist_profiles WHERE user_id = $artist_id");
$artist_profile = mysqli_fetch_assoc($profile_query);

$artworks_query = mysqli_query($conn, "
    SELECT * FROM artworks 
    WHERE artist_id = $artist_id AND is_purchased_by_hiranya = 0 AND status = 'available' 
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($artist_user['username']); ?> - Hiranya Artist Profile</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/profile.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'partials/navbar.php'; ?>

    <div class="profile-hero" style="background-image: url('assets/img/banner-placeholder.jpg'); background-size: cover; background-position: center;"></div>
    
    <div class="container" style="margin-top: -90px; margin-bottom: 50px;">
        <div class="profile-card bg-white p-4 p-md-5 rounded shadow-sm">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4 text-center text-md-start">
                <div class="profile-avatar border border-4 border-white shadow-sm" style="width: 130px; height: 130px; border-radius: 50%; background-color: #1C2431; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 48px; font-family: 'Cinzel', serif;">
                    <?php if (!empty($artist_profile['profile_image'])): ?>
                        <img src="uploads/<?= htmlspecialchars($artist_profile['profile_image']); ?>" alt="Profile avatar" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                    <?php else: ?>
                        <?= strtoupper(substr($artist_user['username'], 0, 1)); ?>
                    <?php endif; ?>
                </div>
                <div class="flex-grow-1">
                    <h2 class="profile-name mb-1" style="font-family: 'Playfair Display', serif; color: #1C2431; font-weight: 700;"><?= htmlspecialchars($artist_user['username']); ?></h2>
                    <p class="profile-username text-muted mb-2">@<?= htmlspecialchars(strtolower($artist_user['username'])); ?></p>
                    <span class="badge text-uppercase py-2 px-3 bg-secondary">Verified Artist</span>
                </div>
            </div>
            
            <div class="profile-divider my-4"></div>
            <div class="row g-4">
                <div class="col-lg-4 border-end">
                    <div class="section-label mb-3 text-uppercase small tracking-wide font-monospace" style="color: #ab8e5b;">About the Artist</div>
                    <p class="text-secondary small mb-3">
                        <?= !empty($artist_profile['bio']) ? nl2br(htmlspecialchars($artist_profile['bio'])) : 'Professional artist showcasing exclusive artworks at Hiranya Art House.'; ?>
                    </p>
                    <?php if (!empty($artist_profile['website'])): ?>
                        <div class="info-row d-flex justify-content-between border-top py-2">
                            <span class="text-muted small">Website</span>
                            <a href="<?= htmlspecialchars($artist_profile['website']); ?>" target="_blank" class="small" style="color: #ab8e5b;"><?= htmlspecialchars($artist_profile['website']); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="info-row d-flex justify-content-between border-top py-2 mb-3">
                        <span class="text-muted small">Contact</span>
                        <span class="small text-dark font-monospace"><?= htmlspecialchars($artist_user['email']); ?></span>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <h4 class="mb-4" style="font-family: 'Playfair Display', serif; font-weight: 600; color: #1C2431;">Available Artworks (Direct Sale)</h4>
                    
                    <?php if (mysqli_num_rows($artworks_query) === 0): ?>
                        <div class="text-center py-5 bg-light rounded">
                            <i class="fa fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">There are no direct sale artworks available from this artist at the moment.</p>
                        </div>
                    <?php else: ?>
                        <div class="row g-4">
                            <?php while ($art = mysqli_fetch_assoc($artworks_query)): 
                                $artist_price = $art['price'];
                                $commission = $artist_price * 0.05; 
                                $total_checkout = $artist_price + $commission;
                            ?>
                                <div class="col-md-6">
                                    <div class="art-card h-100 d-flex flex-column">
                                        <div class="art-image-wrapper position-relative">
                                            <img src="uploads/<?= htmlspecialchars($art['image_url']); ?>" alt="<?= htmlspecialchars($art['title']); ?>">
                                            <span class="badge position-absolute top-0 end-0 m-2 px-3 py-2 bg-warning text-white" style="font-size: 10px; font-weight: 600;">DIRECT SALE</span>
                                        </div>
                                        <div class="p-3 d-flex flex-column flex-grow-1">
                                            <h5 class="mb-1 text-dark" style="font-family: 'Playfair Display', serif; font-weight: bold;"><?= htmlspecialchars($art['title']); ?></h5>
                                            <p class="text-muted small flex-grow-1 text-truncate" style="max-height: 40px;"><?= htmlspecialchars($art['description']); ?></p>
                                            
                                            <div class="border-top pt-2 mt-2">
                                                <div class="d-flex justify-content-between small text-muted">
                                                    <span>Price from Artist:</span>
                                                    <span>Rp <?= number_format($artist_price, 0, ',', '.'); ?></span>
                                                </div>
                                                <div class="d-flex justify-content-between small text-muted mb-1">
                                                    <span>Platform Commission (5%):</span>
                                                    <span>Rp <?= number_format($commission, 0, ',', '.'); ?></span>
                                                </div>
                                                <div class="d-flex justify-content-between fw-bold text-dark border-top pt-1">
                                                    <span>Total Checkout:</span>
                                                    <span style="color:#ab8e5b;">Rp <?= number_format($total_checkout, 0, ',', '.'); ?></span>
                                                </div>
                                            </div>
                                            
                                            <a href="checkout.php?artwork_id=<?= $art['id']; ?>" class="btn btn-buy-direct btn-sm w-100 mt-3 py-2">
                                                <i class="fa fa-shopping-bag me-1"></i> BUY NOW
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5">
        <div class="container py-4 text-center">
            <p>&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
