<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Anda harus login untuk melakukan bid!";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artwork_id = (int)$_POST['artwork_id'];
    $bid_amount = (double)$_POST['bid_amount'];
    $user_id = $_SESSION['user_id'];

    if ($artwork_id <= 0 || $bid_amount <= 0) {
        $_SESSION['message'] = "Data bid tidak valid!";
        $_SESSION['message_type'] = "danger";
        header("Location: auction.php");
        exit();
    }

    // Fetch the active auction
    $auc_query = mysqli_query($conn, "SELECT * FROM auctions WHERE artwork_id = $artwork_id AND status = 'active'");
    if (mysqli_num_rows($auc_query) === 0) {
        $_SESSION['message'] = "Lelang tidak ditemukan atau sudah berakhir!";
        $_SESSION['message_type'] = "danger";
        header("Location: auction.php");
        exit();
    }

    $auction = mysqli_fetch_assoc($auc_query);
    $auction_id = $auction['id'];
    $current_bid = $auction['current_bid'];
    $start_bid = $auction['start_bid'];
    $end_time = $auction['end_time'];

    // Check if auction time is ended
    $now = date('Y-m-d H:i:s');
    if ($now > $end_time) {
        // Automatically end the auction
        mysqli_query($conn, "UPDATE auctions SET status = 'ended' WHERE id = $auction_id");
        $_SESSION['message'] = "Lelang ini sudah berakhir!";
        $_SESSION['message_type'] = "danger";
        header("Location: bidding.php?id=" . $artwork_id);
        exit();
    }

    // Bid amount must be higher than current bid
    $minimum_bid = ($current_bid > 0) ? $current_bid : $start_bid;
    if ($bid_amount <= $minimum_bid) {
        $_SESSION['message'] = "Penawaran Anda harus lebih tinggi dari penawaran saat ini (Rp " . number_format($minimum_bid, 0, ',', '.') . ")!";
        $_SESSION['message_type'] = "danger";
        header("Location: bidding.php?id=" . $artwork_id);
        exit();
    }

    mysqli_begin_transaction($conn);
    try {
        // Insert bid
        $ins_query = "INSERT INTO bids (auction_id, user_id, bid_amount) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $ins_query);
        mysqli_stmt_bind_param($stmt, "iid", $auction_id, $user_id, $bid_amount);
        mysqli_stmt_execute($stmt);

        // Update auction current_bid
        $upd_query = "UPDATE auctions SET current_bid = ? WHERE id = ?";
        $upd_stmt = mysqli_prepare($conn, $upd_query);
        mysqli_stmt_bind_param($upd_stmt, "di", $bid_amount, $auction_id);
        mysqli_stmt_execute($upd_stmt);

        mysqli_commit($conn);
        $_SESSION['message'] = "Penawaran Anda berhasil diajukan!";
        $_SESSION['message_type'] = "success";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['message'] = "Gagal memproses penawaran: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }

    header("Location: bidding.php?id=" . $artwork_id);
    exit();
} else {
    header("Location: auction.php");
    exit();
}
?>
