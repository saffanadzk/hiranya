<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: auction.php");
    exit();
}

$art_query = mysqli_query($conn, "
    SELECT artworks.*, users.username AS artist_name 
    FROM artworks 
    LEFT JOIN users ON artworks.artist_id = users.id 
    WHERE artworks.id = $id
");
if (mysqli_num_rows($art_query) === 0) {
    die("Artwork not found.");
}
$artwork = mysqli_fetch_assoc($art_query);

$auc_query = mysqli_query($conn, "SELECT * FROM auctions WHERE artwork_id = $id");
if (mysqli_num_rows($auc_query) === 0) {
    die("Auction details not found.");
}
$auction = mysqli_fetch_assoc($auc_query);
$auction_id = $auction['id'];

$now = date('Y-m-d H:i:s');
$is_ended = ($now > $auction['end_time'] || $auction['status'] === 'ended');

if ($is_ended && $auction['status'] === 'active') {
    mysqli_begin_transaction($conn);
    try {
        $top_bid_query = mysqli_query($conn, "SELECT user_id FROM bids WHERE auction_id = $auction_id ORDER BY bid_amount DESC LIMIT 1");
        if (mysqli_num_rows($top_bid_query) > 0) {
            $top_bid = mysqli_fetch_assoc($top_bid_query);
            $winner_id = $top_bid['user_id'];
            
            mysqli_query($conn, "UPDATE auctions SET winner_id = $winner_id, status = 'ended' WHERE id = $auction_id");
            
            $msg_winner = "Congratulations! You have won the auction for '" . $artwork['title'] . "' with a bid of Rp " . number_format($auction['current_bid'], 0, ',', '.') . ". Please complete the payment.";
            mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ($winner_id, '$msg_winner')");
        } else {
            mysqli_query($conn, "UPDATE auctions SET status = 'ended' WHERE id = $auction_id");
        }
        mysqli_commit($conn);
        
        $auc_query = mysqli_query($conn, "SELECT * FROM auctions WHERE artwork_id = $id");
        $auction = mysqli_fetch_assoc($auc_query);
    } catch (Exception $e) {
        mysqli_rollback($conn);
    }
}

$bids_query = mysqli_query($conn, "
    SELECT bids.*, users.username 
    FROM bids 
    JOIN users ON bids.user_id = users.id 
    WHERE bids.auction_id = $auction_id 
    ORDER BY bids.bid_amount DESC
");
$bids = [];
while ($row = mysqli_fetch_assoc($bids_query)) {
    $bids[] = $row;
}

$winner_name = '';
if ($auction['winner_id'] > 0) {
    $win_u_query = mysqli_query($conn, "SELECT username FROM users WHERE id = " . $auction['winner_id']);
    $win_u = mysqli_fetch_assoc($win_u_query);
    $winner_name = $win_u['username'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hiranya Bidding - <?= htmlspecialchars($artwork['title']); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css?v=1.3" rel="stylesheet">
    <link href="assets/css/dark_mode.css?v=1.3" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
</head>
<body class="<?= $theme_class; ?>">

    <?php include 'partials/navbar.php'; ?>

    <div class="container py-5">
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show shadow-sm mb-4" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>

        <?php if ($is_ended): ?>
            <div class="alert alert-dark border-0 p-4 mb-4 rounded shadow-sm d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" style="background-color: #1C2431; color: white;">
                <div>
                    <h5 class="mb-1 text-warning" style="font-family: 'Playfair Display', serif;"><i class="fa fa-info-circle me-2"></i>Auction Has Ended</h5>
                    <p class="mb-0 small text-light">
                        <?php if (!empty($winner_name)): ?>
                            The winner of this auction is <strong class="text-warning">@<?= htmlspecialchars($winner_name); ?></strong> with the highest bid of <strong>Rp <?= number_format($auction['current_bid'], 0, ',', '.'); ?></strong>.
                        <?php else: ?>
                            The auction ended without any bids received.
                        <?php endif; ?>
                    </p>
                </div>
                <?php if ($auction['winner_id'] == $_SESSION['user_id']): ?>
                    <a href="checkout.php?artwork_id=<?= $id; ?>&auction_id=<?= $auction_id; ?>" class="btn text-white py-2 px-4" style="background-color:#ab8e5b; letter-spacing:1px; font-weight:600;">SELESAIKAN PEMBAYARAN</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="row g-5">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded overflow-hidden">
                    <img src="uploads/<?= htmlspecialchars($artwork['image_url']); ?>" class="img-fluid" alt="<?= htmlspecialchars($artwork['title']); ?>" style="width:100%; max-height:autoject-fit:cover;">
                    <div class="p-4 bg-white">
                        <h2 style="font-family: 'Playfair Display', serif; font-weight: 700; color: #1C2431;"><?= htmlspecialchars($artwork['title']); ?></h2>
                        <p class="text-muted small">by @<?= htmlspecialchars($artwork['artist_name']); ?></p>
                        <div class="my-3"></div>
                        <p class="text-secondary small mb-0"><?= nl2br(htmlspecialchars($artwork['description'])); ?></p>
                        
                        <div class="d-flex align-items-center gap-3 mt-4 pt-3 border-0">
                            <div id="artwork-qrcode" style="width: 80px; height: 80px;" class="border p-1 bg-white rounded"></div>
                            <div>
                                <h6 class="mb-1 text-dark" style="font-size: 13px; font-weight: 600;">Scan to Share</h6>
                                <p class="text-muted mb-0" style="font-size: 11px; line-height: 1.4;">Share this artwork detail with other collectors by scanning this QR Code.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="info-card p-4 shadow-sm mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge px-3 py-2 text-white bg-dark text-uppercase" style="font-size:10px; letter-spacing: 1px;">
                            <?= htmlspecialchars($auction['auction_type']); ?> Auction
                        </span>
                        <span class="text-danger small font-monospace">
                            <i class="fa fa-clock me-1"></i>
                            <?php if ($is_ended): ?>
                                Ended
                            <?php else: ?>
                                Time Remaining: <strong class="countdown-timer" data-end="<?= $auction['end_time']; ?>"><?= date('d M H:i', strtotime($auction['end_time'])); ?></strong>
                            <?php endif; ?>
                        </span>
                    </div>

                    <div class="row g-3 py-3 border-top border-bottom mb-4">
                        <div class="col-6">
                            <small class="text-muted d-block">Start Bid:</small>
                            <span class="fw-semibold text-dark">Rp <?= number_format($auction['start_bid'], 0, ',', '.'); ?></span>
                        </div>
                        <div class="col-6 border-start ps-3">
                            <small class="text-muted d-block">Current Bid (Highest):</small>
                            <span class="fw-bold text-success" style="font-size: 18px;">Rp <?= number_format($auction['current_bid'], 0, ',', '.'); ?></span>
                        </div>
                    </div>

                    <?php if (!$is_ended && isset($_SESSION['user_id'])): ?>
                        <form action="process_bid.php" method="POST">
                            <input type="hidden" name="artwork_id" value="<?= $id; ?>">
                            <div class="mb-3">
                                <label class="form-label small text-muted">Enter Your Bid (IDR)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted">Rp</span>
                                    <input type="number" name="bid_amount" class="form-control" placeholder="Must be higher than Rp <?= number_format($auction['current_bid'], 0, ',', '.'); ?>" min="<?= $auction['current_bid'] + 1; ?>" required>
                                </div>
                            </div>
                            <button type="submit" class="btn text-white w-100 py-3" style="background-color: #ab8e5b; letter-spacing: 1px; font-weight:600;">SUBMIT BID</button>
                        </form>
                    <?php elseif (!$is_ended): ?>
                        <div class="alert alert-warning text-center small mb-0">
                            Please <a href="login.php" class="fw-bold">Login</a> first to participate in this auction.
                        </div>
                    <?php endif; ?>
                </div>

                <div class="bg-white p-4 rounded shadow-sm info-card">
                    <h5 class="mb-3" style="font-family: 'Playfair Display', serif; font-weight:600;"><i class="fa fa-trophy me-2 text-warning"></i>Leaderboard Bid</h5>
                    
                    <div class="leaderboard-list">
                        <?php if (empty($bids)): ?>
                            <p class="text-muted text-center py-4 small mb-0">No bids yet. Be the first to bid!</p>
                        <?php else: ?>
                            <?php 
                            $rank = 1;
                            foreach ($bids as $bid): 
                            ?>
                                <div class="leaderboard-item d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="rank-badge <?= ($rank === 1) ? 'rank-1' : 'rank-other'; ?>">
                                            <?= $rank; ?>
                                        </span>
                                        <div>
                                            <h6 class="mb-0 text-dark small">@<?= htmlspecialchars($bid['username']); ?></h6>
                                            <small class="text-muted font-monospace" style="font-size: 10px;"><?= date('d M H:i:s', strtotime($bid['bid_time'])); ?></small>
                                        </div>
                                    </div>
                                    <span class="fw-bold text-dark small">
                                        Rp <?= number_format($bid['bid_amount'], 0, ',', '.'); ?>
                                    </span>
                                </div>
                            <?php 
                            $rank++;
                            endforeach; 
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="container-fluid footer bg-dark text-white-50 py-5 mt-5">
        <div class="container py-4 text-center">
            <p class="mb-0">&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateTimers() {
            const timers = document.querySelectorAll(".countdown-timer");
            timers.forEach(timer => {
                const endTimeStr = timer.getAttribute("data-end");
                const endTime = new Date(endTimeStr.replace(/-/g, "/")).getTime();
                const now = new Date().getTime();
                const distance = endTime - now;
                
                if (distance < 0) {
                    timer.innerHTML = "Ended";
                    timer.classList.remove("text-danger");
                    timer.classList.add("text-muted");
                } else {
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                    let timeStr = "";
                    if (days > 0) timeStr += days + "d ";
                    timeStr += hours + "h " + minutes + "m " + seconds + "s";
                    timer.innerHTML = timeStr;
                }
            });
        }
        updateTimers();
        setInterval(updateTimers, 1000);
    });
    </script>
    <script src="assets/js/qrcode_helper.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Generate QR code for current bidding page URL
        const protocol = window.location.protocol;
        const host = window.location.host;
        const currentUrl = protocol + '//' + host + '/hiranya/bidding.php?id=<?= $id; ?>';
        generateQRCode('artwork-qrcode', currentUrl, 80, 80);
    });
    </script>
</body>
</html>