<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must login to place a bid!";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artwork_id = (int)$_POST['artwork_id'];
    $bid_amount = (double)$_POST['bid_amount'];
    $user_id = $_SESSION['user_id'];

    if ($artwork_id <= 0 || $bid_amount <= 0) {
        $_SESSION['message'] = "Invalid bid data!";
        $_SESSION['message_type'] = "danger";
        header("Location: auction.php");
        exit();
    }

    $auc_query = mysqli_query($conn, "SELECT * FROM auctions WHERE artwork_id = $artwork_id AND status = 'active'");
    if (mysqli_num_rows($auc_query) === 0) {
        $_SESSION['message'] = "Auction not found or has ended!";
        $_SESSION['message_type'] = "danger";
        header("Location: auction.php");
        exit();
    }

    $auction = mysqli_fetch_assoc($auc_query);
    $auction_id = $auction['id'];
    $current_bid = $auction['current_bid'];
    $start_bid = $auction['start_bid'];
    $end_time = $auction['end_time'];

    $now = date('Y-m-d H:i:s');
    if ($now > $end_time) {
        mysqli_query($conn, "UPDATE auctions SET status = 'ended' WHERE id = $auction_id");
        $_SESSION['message'] = "This auction has ended!";
        $_SESSION['message_type'] = "danger";
        header("Location: bidding.php?id=" . $artwork_id);
        exit();
    }

    $minimum_bid = ($current_bid > 0) ? $current_bid : $start_bid;
    if ($bid_amount <= $minimum_bid) {
        $_SESSION['message'] = "Your bid must be higher than the current bid (Rp " . number_format($minimum_bid, 0, ',', '.') . ")!";
        $_SESSION['message_type'] = "danger";
        header("Location: bidding.php?id=" . $artwork_id);
        exit();
    }

    mysqli_begin_transaction($conn);
    try {
        $ins_query = "INSERT INTO bids (auction_id, user_id, bid_amount) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $ins_query);
        mysqli_stmt_bind_param($stmt, "iid", $auction_id, $user_id, $bid_amount);
        mysqli_stmt_execute($stmt);

        $upd_query = "UPDATE auctions SET current_bid = ? WHERE id = ?";
        $upd_stmt = mysqli_prepare($conn, $upd_query);
        mysqli_stmt_bind_param($upd_stmt, "di", $bid_amount, $auction_id);
        mysqli_stmt_execute($upd_stmt);

        mysqli_commit($conn);
        $_SESSION['message'] = "Your bid has been submitted successfully!";
        $_SESSION['message_type'] = "success";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['message'] = "Failed to process bid: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }

    header("Location: bidding.php?id=" . $artwork_id);
    exit();
} else {
    header("Location: auction.php");
    exit();
}
?>
