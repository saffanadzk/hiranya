<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$artists_query = mysqli_query($conn, "
    SELECT users.id, users.username, artist_profiles.profile_image, artist_profiles.bio
    FROM users
    LEFT JOIN artist_profiles ON users.id = artist_profiles.user_id
    WHERE users.role_id = 2
");
$artists_count = mysqli_num_rows($artists_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>All Artists | Hiranya House</title>

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
            <h1 class="font-playfair-display mb-2">All Artists</h1>
            <p class="discover-sub">Discover the talents represented and curated by Hiranya</p>
        </div>
    </div>
    <div class="container-fluid py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <p class="result-count mb-0"><?= $artists_count; ?> artist(s)</p>
            </div>
            <div class="shelf-grid">
                <?php if ($artists_count === 0): ?>
                    <p class="text-muted py-4">No Artist listed in Hiranya.</p>
                <?php else: ?>
                    <?php while ($artist = mysqli_fetch_assoc($artists_query)): ?>
                        <div class="shelf-item" style="box-shadow: 0 4px 12px rgba(39, 49, 105, 0.05); border-radius: 8px; overflow: hidden; background: #eeededff; padding: 15px; text-align: center;">
                            <a href="artist_profile.php?id=<?= $artist['id']; ?>" class="shelf-cover" style="display: block; height: 200px; overflow: hidden; margin-bottom: 15px;">
                                <?php if (!empty($artist['profile_image'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($artist['profile_image']); ?>" alt="<?= htmlspecialchars($artist['username']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-dark text-white d-flex align-items-center justify-content-center" style="height: 100%; font-size: 36px; font-family: 'Cinzel', serif;">
                                        <?= strtoupper(substr($artist['username'], 0, 1)); ?>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <h6 class="shelf-title" style="font-family: 'Playfair Display', serif; font-size: 18px; margin-bottom: 5px; color: #121F45;"><?= htmlspecialchars($artist['username']); ?></h6>
                            <p class="shelf-meta" style="font-size: 13px; color: #666; height: 40px; overflow: hidden;"><?= !empty($artist['bio']) ? htmlspecialchars(substr($artist['bio'], 0, 60)) . '...' : 'Artist represented by Hiranya'; ?></p>
                            <div class="shelf-rating" style="margin-top: 10px;">
                                <a href="artist_profile.php?id=<?= $artist['id']; ?>" class="btn btn-sm text-white w-100" style="background-color: #c5313e; font-size: 13px; letter-spacing: 1px;">VIEW ARTIST</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
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