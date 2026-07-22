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
        // Look up previous highest bidder before inserting the new bid
        $prev_bid_query = mysqli_query($conn, "
            SELECT bids.user_id, users.email, users.username 
            FROM bids 
            JOIN users ON bids.user_id = users.id 
            WHERE bids.auction_id = $auction_id 
            ORDER BY bids.bid_amount DESC LIMIT 1
        ");
        
        $prev_bidder = null;
        if (mysqli_num_rows($prev_bid_query) > 0) {
            $prev_bidder = mysqli_fetch_assoc($prev_bid_query);
        }

        $ins_query = "INSERT INTO bids (auction_id, user_id, bid_amount) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $ins_query);
        mysqli_stmt_bind_param($stmt, "iid", $auction_id, $user_id, $bid_amount);
        mysqli_stmt_execute($stmt);

        $upd_query = "UPDATE auctions SET current_bid = ? WHERE id = ?";
        $upd_stmt = mysqli_prepare($conn, $upd_query);
        mysqli_stmt_bind_param($upd_stmt, "di", $bid_amount, $auction_id);
        mysqli_stmt_execute($upd_stmt);

        // If a previous bidder exists and it's not the same user, notify them!
        if ($prev_bidder && (int)$prev_bidder['user_id'] !== $user_id) {
            $prev_uid = $prev_bidder['user_id'];
            $art_title = $artwork['title'];
            $outbid_msg = "Anda telah dikalahkan (outbid) pada lelang karya '$art_title'! Tawaran baru adalah Rp " . number_format($bid_amount, 0, ',', '.') . ".";
            
            // Insert in-app notification
            mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ($prev_uid, '$outbid_msg')");
        }

        mysqli_commit($conn);

        // Send email outbid notification after successful commit
        if ($prev_bidder && (int)$prev_bidder['user_id'] !== $user_id) {
            require_once 'mail_helper.php';
            $art_title = $artwork['title'];
            $subject = "Outbid Notice! - Hiranya Art House";
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
            $bid_link = $protocol . "://" . $_SERVER['HTTP_HOST'] . "/hiranya/bidding.php?id=" . $artwork_id;
            
            $body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #fdfdfd;'>
                    <div style='text-align: center; border-bottom: 2px solid #ab8e5b; padding-bottom: 10px;'>
                        <h2 style='color: #1c2431; font-family: \"Cinzel\", serif;'>Hiranya Art House</h2>
                    </div>
                    <div style='padding: 20px 0;'>
                        <h3 style='color: #dc3545; text-align: center;'>You've Been Outbid!</h3>
                        <p style='color: #555; line-height: 1.6;'>Dear @{$prev_bidder['username']},</p>
                        <p style='color: #555; line-height: 1.6;'>This is to inform you that another collector has placed a higher bid on the artwork <strong>'{$art_title}'</strong>.</p>
                        <p style='color: #555; line-height: 1.6;'>The new highest bid is <strong style='color: #28a745;'>Rp " . number_format($bid_amount, 0, ',', '.') . "</strong>.</p>
                        <p style='color: #555; line-height: 1.6;'>If you still want to win this artwork, please place a new, higher bid by clicking the button below:</p>
                        <div style='text-align: center; margin: 30px 0;'>
                            <a href='{$bid_link}' style='background-color: #ab8e5b; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 15px; display: inline-block;'>Place a Higher Bid</a>
                        </div>
                        <p style='color: #777; font-size: 11px; text-align: center;'>Best of luck,<br>Hiranya Art House Team</p>
                    </div>
                    <div style='border-top: 1px solid #eee; padding-top: 15px; text-align: center; color: #aaa; font-size: 11px;'>
                        <p>&copy; " . date('Y') . " Hiranya Art House. All rights reserved.</p>
                    </div>
                </div>
            ";
            send_email($prev_bidder['email'], $subject, $body);
        }

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
