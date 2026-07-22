<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['message'] = "Access denied! You must be logged in as an admin.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit;
}
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add_category') {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        if (!empty($name)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $query = "INSERT INTO categories (name, slug) VALUES (?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $name, $slug);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Category '$name' added successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to add category: " . mysqli_error($conn);
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Category name cannot be empty!";
            $_SESSION['message_type'] = "warning";
        }
    }
    elseif ($action === 'edit_category') {
        $id = (int)$_POST['id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        if (!empty($name) && $id > 0) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
            $query = "UPDATE categories SET name = ?, slug = ? WHERE id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $name, $slug, $id);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Category updated successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to update category: " . mysqli_error($conn);
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Invalid input!";
            $_SESSION['message_type'] = "warning";
        }
    }
    elseif ($action === 'assign_category') {
        $artwork_id = (int)$_POST['artwork_id'];
        $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;

        if ($artwork_id > 0) {
            if ($category_id === null || $category_id === 0) {
                $query = "UPDATE artworks SET category_id = NULL WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $artwork_id);
            } else {
                $query = "UPDATE artworks SET category_id = ? WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ii", $category_id, $artwork_id);
            }

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Artwork category updated successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to update artwork category: " . mysqli_error($conn);
                $_SESSION['message_type'] = "danger";
            }
        }
    }

    elseif ($action === 'assign_auction') {
        $artwork_id = (int)$_POST['artwork_id'];
        $start_bid = (double)$_POST['start_bid'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $auction_type = isset($_POST['auction_type']) ? $_POST['auction_type'] : 'online';

        if ($artwork_id > 0 && $start_bid >= 0 && !empty($start_time) && !empty($end_time)) {
            mysqli_begin_transaction($conn);

            try {
                $del_query = "DELETE FROM auctions WHERE artwork_id = ?";
                $del_stmt = mysqli_prepare($conn, $del_query);
                mysqli_stmt_bind_param($del_stmt, "i", $artwork_id);
                mysqli_stmt_execute($del_stmt);

                $ins_query = "INSERT INTO auctions (artwork_id, start_bid, current_bid, start_time, end_time, status, auction_type) VALUES (?, ?, ?, ?, ?, 'active', ?)";
                $ins_stmt = mysqli_prepare($conn, $ins_query);
                mysqli_stmt_bind_param($ins_stmt, "iddsss", $artwork_id, $start_bid, $start_bid, $start_time, $end_time, $auction_type);
                mysqli_stmt_execute($ins_stmt);

                $upd_query = "UPDATE artworks SET status = 'in_auction' WHERE id = ?";
                $upd_stmt = mysqli_prepare($conn, $upd_query);
                mysqli_stmt_bind_param($upd_stmt, "i", $artwork_id);
                mysqli_stmt_execute($upd_stmt);

                mysqli_commit($conn);
                $_SESSION['message'] = "Artwork added to auction successfully!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Failed to add to auction: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Incomplete or invalid auction data!";
            $_SESSION['message_type'] = "warning";
        }
    }
    elseif ($action === 'buy_artwork') {
        $artwork_id = (int)$_POST['artwork_id'];
        $hiranya_price = (double)$_POST['hiranya_price'];

        if ($artwork_id > 0 && $hiranya_price >= 0) {
            mysqli_begin_transaction($conn);
            try {
                $art_query = mysqli_query($conn, "SELECT title, artist_id, price FROM artworks WHERE id = $artwork_id");
                $art_data = mysqli_fetch_assoc($art_query);
                $title = $art_data['title'];
                $artist_id = $art_data['artist_id'];
                $artist_price = $art_data['price'];

                $upd_query = "UPDATE artworks SET is_purchased_by_hiranya = 1, hiranya_price = ?, price = ? WHERE id = ?";
                $stmt = mysqli_prepare($conn, $upd_query);
                $stmt_params = [$hiranya_price, $hiranya_price, $artwork_id];
                mysqli_stmt_bind_param($stmt, "ddi", ...$stmt_params);
                mysqli_stmt_execute($stmt);

                $message = "Hiranya membeli karya Anda yang berjudul '$title' seharga Rp " . number_format($artist_price, 0, ',', '.') . "! Karya Anda kini masuk ke listing Hiranya dengan harga jual Rp " . number_format($hiranya_price, 0, ',', '.') . ".";
                $notif_query = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
                $notif_stmt = mysqli_prepare($conn, $notif_query);
                mysqli_stmt_bind_param($notif_stmt, "is", $artist_id, $message);
                mysqli_stmt_execute($notif_stmt);

                mysqli_commit($conn);

                // Send email notification to artist
                $artist_email_query = mysqli_query($conn, "SELECT email, username FROM users WHERE id = $artist_id");
                if (mysqli_num_rows($artist_email_query) > 0) {
                    $artist_data = mysqli_fetch_assoc($artist_email_query);
                    require_once 'mail_helper.php';
                    $subject = "Your Artwork Purchased by Hiranya Art House!";
                    $body = "
                        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                            <h2 style='color: #ab8e5b; text-align: center;'>Artwork Purchased!</h2>
                            <p>Dear @{$artist_data['username']},</p>
                            <p>We are excited to inform you that <strong>Hiranya Art House</strong> has purchased your artwork <strong>'{$title}'</strong> for <strong>Rp " . number_format($artist_price, 0, ',', '.') . "</strong>.</p>
                            <p>This artwork is now owned by Hiranya and will be featured in our collections. The funds will be processed to your registered bank account shortly.</p>
                            <br>
                            <p>Best regards,<br>Hiranya Art House Team</p>
                        </div>
                    ";
                    send_email($artist_data['email'], $subject, $body);
                }

                $_SESSION['message'] = "Artwork successfully bought by Hiranya!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Failed to buy artwork: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        }
    }
    elseif ($action === 'verify_payment') {
        $order_id = (int)$_POST['order_id'];
        $status = $_POST['status']; 

        if ($order_id > 0 && in_array($status, ['verified', 'rejected'])) {
            mysqli_begin_transaction($conn);
            try {
                $upd_query = "UPDATE orders SET payment_status = ? WHERE id = ?";
                $stmt = mysqli_prepare($conn, $upd_query);
                mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
                mysqli_stmt_execute($stmt);

                // Fetch details for email notification
                $order_info_query = mysqli_query($conn, "
                    SELECT orders.amount, artworks.title AS art_title, users.email, users.username
                    FROM orders
                    JOIN artworks ON orders.artwork_id = artworks.id
                    JOIN users ON orders.buyer_id = users.id
                    WHERE orders.id = $order_id
                ");
                $order_info = mysqli_fetch_assoc($order_info_query);

                if ($status === 'verified') {
                    $order_query = mysqli_query($conn, "SELECT artwork_id FROM orders WHERE id = $order_id");
                    $order_data = mysqli_fetch_assoc($order_query);
                    $artwork_id = $order_data['artwork_id'];

                    $art_upd = "UPDATE artworks SET status = 'sold' WHERE id = ?";
                    $art_stmt = mysqli_prepare($conn, $art_upd);
                    mysqli_stmt_bind_param($art_stmt, "i", $artwork_id);
                    mysqli_stmt_execute($art_stmt);

                    mysqli_query($conn, "UPDATE auctions SET status = 'ended' WHERE artwork_id = $artwork_id");

                    // In-app Notification for Buyer
                    $buyer_id_query = mysqli_query($conn, "SELECT buyer_id FROM orders WHERE id = $order_id");
                    $buyer_row = mysqli_fetch_assoc($buyer_id_query);
                    $buyer_id = $buyer_row['buyer_id'];
                    $msg_buyer = "Pembayaran Anda untuk karya '" . $order_info['art_title'] . "' telah diverifikasi oleh admin. Terima kasih atas pembelian Anda!";
                    mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ($buyer_id, '$msg_buyer')");
                } else {
                    // Rejected
                    $buyer_id_query = mysqli_query($conn, "SELECT buyer_id FROM orders WHERE id = $order_id");
                    $buyer_row = mysqli_fetch_assoc($buyer_id_query);
                    $buyer_id = $buyer_row['buyer_id'];
                    $msg_buyer = "Pembayaran Anda untuk karya '" . $order_info['art_title'] . "' ditolak oleh admin. Silakan unggah bukti transfer yang valid.";
                    mysqli_query($conn, "INSERT INTO notifications (user_id, message) VALUES ($buyer_id, '$msg_buyer')");
                }

                mysqli_commit($conn);

                // Send email notification to buyer
                if ($order_info) {
                    require_once 'mail_helper.php';
                    $subject = $status === 'verified' ? "Payment Verified! - Hiranya Art House" : "Payment Rejected - Hiranya Art House";
                    
                    if ($status === 'verified') {
                        $body = "
                            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                                <h2 style='color: #28a745; text-align: center;'>Payment Verified Successfully!</h2>
                                <p>Dear @{$order_info['username']},</p>
                                <p>We are pleased to inform you that your payment of <strong>Rp " . number_format($order_info['amount'], 0, ',', '.') . "</strong> for the artwork <strong>'{$order_info['art_title']}'</strong> has been verified by our administrator.</p>
                                <p>The artwork is now officially yours. You can view your purchase details in your profile dashboard.</p>
                                <br>
                                <p>Thank you for bidding/purchasing with Hiranya!<br>Hiranya Art House Team</p>
                            </div>
                        ";
                    } else {
                        $body = "
                            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
                                <h2 style='color: #dc3545; text-align: center;'>Payment Proof Rejected</h2>
                                <p>Dear @{$order_info['username']},</p>
                                <p>Unfortunately, the proof of transfer you uploaded for the artwork <strong>'{$order_info['art_title']}'</strong> has been rejected by our administrator.</p>
                                <p>Please double-check your transfer reference and upload a clear receipt of payment by visiting the order details/checkout page again.</p>
                                <br>
                                <p>Best regards,<br>Hiranya Art House Team</p>
                            </div>
                        ";
                    }
                    send_email($order_info['email'], $subject, $body);
                }

                $_SESSION['message'] = "Payment successfully verified (" . ucfirst($status) . ")!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Failed to verify payment: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        }
    }

    elseif ($action === 'upload_private_artwork') {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $price = (double)$_POST['price'];
        $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
        $upload_dir = "uploads/";

        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $image_name = '';

        if (isset($_FILES['artwork_image']) && $_FILES['artwork_image']['error'] == 0) {
            $ext = strtolower(pathinfo($_FILES['artwork_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ext, $allowed)) {
                $_SESSION['message'] = "Image format must be JPG, JPEG, PNG, or WEBP";
                $_SESSION['message_type'] = "danger";
                header("Location: admin_dashboard.php");
                exit;
            }

            $image_name = time() . '_' . uniqid() . '.' . $ext;
            if (!move_uploaded_file($_FILES['artwork_image']['tmp_name'], $upload_dir . $image_name)) {
                $_SESSION['message'] = "Failed to upload image.";
                $_SESSION['message_type'] = "danger";
                header("Location: admin_dashboard.php");
                exit;
            }
        } else {
            $_SESSION['message'] = "Image is required.";
            $_SESSION['message_type'] = "danger";
            header("Location: admin_dashboard.php");
            exit;
        }

        mysqli_begin_transaction($conn);
        try {
            $check_user = mysqli_query($conn, "SELECT id FROM users WHERE username = 'Artist Private Collection'");
            if (mysqli_num_rows($check_user) == 0) {
                mysqli_query($conn, "INSERT INTO users (username, email, password, role_id, role) VALUES ('Artist Private Collection', 'admin@hiranya.com', '', 2, 'artist')");
                $artist_id = mysqli_insert_id($conn);
                mysqli_query($conn, "INSERT INTO artist_profiles (user_id, bio) VALUES ($artist_id, 'Hiranya House Private Collection')");
            } else {
                $user_row = mysqli_fetch_assoc($check_user);
                $artist_id = $user_row['id'];
            }

            $status = "available";
            $is_purchased_by_hiranya = 1;

            if ($category_id === null || $category_id === 0) {
                $stmt = $conn->prepare("
                    INSERT INTO artworks
                    (artist_id, title, description, price, hiranya_price, category_id, image_url, status, is_purchased_by_hiranya)
                    VALUES (?, ?, ?, ?, ?, NULL, ?, ?, ?)
                ");
                $stmt->bind_param("issddssi", $artist_id, $title, $description, $price, $price, $image_name, $status, $is_purchased_by_hiranya);
            } else {
                $stmt = $conn->prepare("
                    INSERT INTO artworks
                    (artist_id, title, description, price, hiranya_price, category_id, image_url, status, is_purchased_by_hiranya)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("issdidssi", $artist_id, $title, $description, $price, $price, $category_id, $image_name, $status, $is_purchased_by_hiranya);
            }

            $stmt->execute();
            mysqli_commit($conn);

            $_SESSION['message'] = "Artwork Private Collection successfully uploaded!";
            $_SESSION['message_type'] = "success";
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $_SESSION['message'] = "Failed to upload artwork: " . $e->getMessage();
            $_SESSION['message_type'] = "danger";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'delete_category') {
        $id = (int)$_GET['id'];
        if ($id > 0) {
            mysqli_begin_transaction($conn);
            try {
                $upd_query = "UPDATE artworks SET category_id = NULL WHERE category_id = ?";
                $upd_stmt = mysqli_prepare($conn, $upd_query);
                mysqli_stmt_bind_param($upd_stmt, "i", $id);
                mysqli_stmt_execute($upd_stmt);

                $del_query = "DELETE FROM categories WHERE id = ?";
                $del_stmt = mysqli_prepare($conn, $del_query);
                mysqli_stmt_bind_param($del_stmt, "i", $id);
                mysqli_stmt_execute($del_stmt);

                mysqli_commit($conn);
                $_SESSION['message'] = "Category successfully deleted!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Failed to delete category: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        }
    }
    elseif ($action === 'remove_auction') {
        $artwork_id = (int)$_GET['artwork_id'];
        if ($artwork_id > 0) {
            mysqli_begin_transaction($conn);
            try {
                $del_query = "DELETE FROM auctions WHERE artwork_id = ?";
                $del_stmt = mysqli_prepare($conn, $del_query);
                mysqli_stmt_bind_param($del_stmt, "i", $artwork_id);
                mysqli_stmt_execute($del_stmt);

                $upd_query = "UPDATE artworks SET status = 'available' WHERE id = ?";
                $upd_stmt = mysqli_prepare($conn, $upd_query);
                mysqli_stmt_bind_param($upd_stmt, "i", $artwork_id);
                mysqli_stmt_execute($upd_stmt);

                mysqli_commit($conn);
                $_SESSION['message'] = "Artwork successfully removed from auction!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Failed to remove from auction: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        }
    }
    elseif ($action === 'delete_artwork') {
        $id = (int)$_GET['id'];
        if ($id > 0) {
            mysqli_begin_transaction($conn);
            try {
                $info_query = "SELECT image_url FROM artworks WHERE id = ?";
                $info_stmt = mysqli_prepare($conn, $info_query);
                mysqli_stmt_bind_param($info_stmt, "i", $id);
                mysqli_stmt_execute($info_stmt);
                $info_res = mysqli_stmt_get_result($info_stmt);
                $art = mysqli_fetch_assoc($info_res);

                $wish_query = "DELETE FROM wishlist WHERE artwork_id = ?";
                $wish_stmt = mysqli_prepare($conn, $wish_query);
                mysqli_stmt_bind_param($wish_stmt, "i", $id);
                mysqli_stmt_execute($wish_stmt);

                $auc_query = "DELETE FROM auctions WHERE artwork_id = ?";
                $auc_stmt = mysqli_prepare($conn, $auc_query);
                mysqli_stmt_bind_param($auc_stmt, "i", $id);
                mysqli_stmt_execute($auc_stmt);

                $del_query = "DELETE FROM artworks WHERE id = ?";
                $del_stmt = mysqli_prepare($conn, $del_query);
                mysqli_stmt_bind_param($del_stmt, "i", $id);
                mysqli_stmt_execute($del_stmt);

                mysqli_commit($conn);

                if ($art && !empty($art['image_url'])) {
                    $file_path = "uploads/" . $art['image_url'];
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }

                $_SESSION['message'] = "Artwork successfully deleted!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Failed to delete artwork: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        }
    }
}
header("Location: admin_dashboard.php");
exit;
?>
