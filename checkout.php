<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$artwork_id = isset($_GET['artwork_id']) ? (int)$_GET['artwork_id'] : 0;
$auction_id = isset($_GET['auction_id']) ? (int)$_GET['auction_id'] : 0;
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
if ($artwork_id <= 0) {
    header("Location: dashboard.php");
    exit();
}

$art_query = mysqli_query($conn, "
    SELECT artworks.*, users.username AS artist_name 
    FROM artworks 
    LEFT JOIN users ON artworks.artist_id = users.id 
    WHERE artworks.id = $artwork_id
");
if (mysqli_num_rows($art_query) === 0) {
    die("Artwork not found.");
}
$artwork = mysqli_fetch_assoc($art_query);
$order_type = 'private_sale';
$amount = $artwork['price'];
$commission_amount = 0.00;

if ($auction_id > 0) {
    $order_type = 'auction';
    $auc_query = mysqli_query($conn, "SELECT current_bid FROM auctions WHERE id = $auction_id");
    if (mysqli_num_rows($auc_query) > 0) {
        $auc = mysqli_fetch_assoc($auc_query);
        $amount = $auc['current_bid'];
    }
} elseif ($artwork['is_purchased_by_hiranya'] == 0) {
    $order_type = 'direct';
    $commission_amount = $artwork['price'] * 0.05;
    $amount = $artwork['price'] + $commission_amount;
}

$artist_bank = null;
if ($order_type === 'direct') {
    $bank_query = mysqli_query($conn, "SELECT bank_name, bank_account, bank_holder FROM artist_profiles WHERE user_id = " . $artwork['artist_id']);
    if (mysqli_num_rows($bank_query) > 0) {
        $artist_bank = mysqli_fetch_assoc($bank_query);
    }
}

$order = null;
if ($order_id > 0) {
    $order_query = mysqli_query($conn, "SELECT * FROM orders WHERE id = $order_id AND buyer_id = " . $_SESSION['user_id']);
    if (mysqli_num_rows($order_query) > 0) {
        $order = mysqli_fetch_assoc($order_query);
        if ($order['artwork_id'] != $artwork_id) {
            die("Order/Artwork mismatch.");
        }
        $order_type = $order['order_type'];
        $amount = $order['amount'];
        $commission_amount = $order['commission_amount'];
    } else {
        die("Order not found or you do not have access to it.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buyer_id = $_SESSION['user_id'];
    
    if ($order_id === 0) {
        mysqli_begin_transaction($conn);
        try {
            $payment_proof = "";
            $ins_query = "INSERT INTO orders (artwork_id, buyer_id, order_type, amount, commission_amount, payment_proof, payment_status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
            $stmt = mysqli_prepare($conn, $ins_query);
            mysqli_stmt_bind_param($stmt, "iisdds", $artwork_id, $buyer_id, $order_type, $amount, $commission_amount, $payment_proof);
            mysqli_stmt_execute($stmt);
            $new_order_id = mysqli_insert_id($conn);

            $unique_code = $new_order_id % 1000;
            $final_amount = $amount + $unique_code;
            mysqli_query($conn, "UPDATE orders SET amount = $final_amount WHERE id = $new_order_id");
            mysqli_commit($conn);
            $_SESSION['message'] = "Checkout successful! Please make payment according to your unique code.";
            $_SESSION['message_type'] = "success";
            header("Location: checkout.php?artwork_id=$artwork_id&order_id=$new_order_id");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $error = "Failed to process checkout: " . $e->getMessage();
        }
    } 
    else {
        if ($order && !empty($order['payment_proof'])) {
            $error = "Payment proof has already been uploaded for this order.";
        } else {
            $upload_dir = "uploads/";
            $payment_proof = "";

            if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === 0) {
                $ext = strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                
                if (!in_array($ext, $allowed)) {
                    $error = "Transfer proof must be in JPG, JPEG, PNG, or PDF format.";
                } else {
                    $payment_proof = 'proof_' . time() . '_' . uniqid() . '.' . $ext;
                    if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $upload_dir . $payment_proof)) {
                        $error = "Failed to upload transfer proof.";
                    }
                }
            } else {
                $error = "Please select a transfer proof file.";
            }

            if (!isset($error)) {
                $upd_query = "UPDATE orders SET payment_proof = ? WHERE id = ?";
                $stmt = mysqli_prepare($conn, $upd_query);
                mysqli_stmt_bind_param($stmt, "si", $payment_proof, $order_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['message'] = "Transfer proof uploaded successfully! Please wait for admin verification.";
                    $_SESSION['message_type'] = "success";
                    header("Location: profile.php");
                    exit();
                } else {
                    $error = "Failed to upload transfer proof: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Artwork - Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css?v=1.2" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=1.2">
</head>
<body class="checkout-page <?= $theme_class; ?>">

    <?php include 'partials/navbar.php'; ?>

    <div class="container py-5">
        <h2 class="mb-4 text-center" style="font-family: 'Playfair Display', serif; font-weight:700; color: #1C2431;">Acquire Artwork Checkout</h2>
        
        <div class="row g-5 justify-content-center">
            <div class="col-lg-8">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="checkout-card p-4 p-md-5 shadow-sm">

                    <div class="d-flex flex-column flex-sm-row gap-4 mb-4 pb-4 border-bottom">
                        <img src="uploads/<?= htmlspecialchars($artwork['image_url']); ?>" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;" alt="">
                        <div>
                            <h4 class="mb-1" style="font-family: 'Playfair Display', serif;"><?= htmlspecialchars($artwork['title']); ?></h4>
                            <p class="text-muted small mb-2">oleh @<?= htmlspecialchars($artwork['artist_name']); ?></p>
                            <span class="badge text-bg-secondary text-uppercase" style="font-size: 10px;">
                                <?= str_replace('_', ' ', $order_type); ?> Transaction
                            </span>
                        </div>
                    </div>

                    <h5 class="mb-3" style="font-family: 'Playfair Display', serif; font-weight:600;">Payment Details</h5>
                    <table class="table align-middle mb-4">
                        <tbody>
                            <?php if ($order_type === 'direct'): ?>
                                <tr>
                                    <td class="text-muted">Price (to Artist)</td>
                                    <td class="text-end text-dark">Rp <?= number_format($artwork['price'], 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Hiranya Service Fee (5%)</td>
                                    <td class="text-end text-dark">Rp <?= number_format($commission_amount, 0, ',', '.'); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td class="text-muted">Price</td>
                                    <td class="text-end text-dark">Rp <?= number_format($amount, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr class="table-light fw-bold">
                                <td class="text-dark">Total Payment</td>
                                <td class="text-end text-dark" style="font-size: 18px; color: #ab8e5b !important;">
                                    Rp <?= number_format($amount, 0, ',', '.'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if ($order_id === 0): ?>
                        <div class="alert checkout-alert-info py-3 mb-4">
                            <h6 class="mb-2 fw-bold text-dark"><i class="fa fa-info-circle text-primary me-2"></i> Confirm Purchase</h6>
                            <p class="mb-0 text-secondary small">Press the button below to confirm your order officially. The destination bank account and unique transaction code will be generated securely after your order is registered in the system.</p>
                        </div>

                        <form method="POST">
                            <button type="submit" class="btn text-white w-100 py-3" style="background-color:#ab8e5b; font-weight:600; letter-spacing:1px; border-radius:6px;">
                                <i class="fa fa-check-circle me-1"></i> CONFIRM CHECKOUT &amp; CREATE ORDER
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert checkout-alert-warning py-3 mb-3">
                            <h6 class="mb-2 fw-bold text-dark"><i class="fa fa-exclamation-triangle text-warning me-2"></i> Secure Payment via Unique Code</h6>
                            <p class="mb-0 text-secondary small">To minimize payment data leakage, please transfer exactly <strong>Rp <?= number_format($amount, 0, ',', '.'); ?></strong> (including the 3-digit unique code). This code uniquely identifies your transaction.</p>
                        </div>

                        <div class="secure-payment-portal p-4 border rounded bg-white mt-4 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                                <h5 class="mb-0 text-dark fw-bold" style="font-family: 'Playfair Display', serif;">
                                    <i class="fa fa-lock text-success me-2"></i> Secure Bank Transfer
                                </h5>
                                <span class="badge text-bg-success px-2 py-1 font-monospace" style="font-size:10px; background-color: #28a745; color: white;">
                                    <i class="fa fa-shield-alt me-1"></i> Masked Bank Details
                                </span>
                            </div>
                            
                            <p class="text-secondary small mb-3">For the security of your transaction, please click the button below to display the official transfer account details.</p>

                            <div id="bank-reveal-container" class="mb-4 text-center">
                                <button type="button" class="btn btn-outline-dark btn-sm px-4 py-2" id="btn-reveal-bank" style="font-size: 13px; font-weight:600; letter-spacing:0.5px;">
                                    <i class="fa fa-eye me-2"></i> Display Payment Account
                                </button>
                            </div>
                            <div id="secure-bank-details" class="d-none">
                                <?php if ($order_type === 'direct'): ?>
                                    <div class="bank-details-box p-3 mb-3">
                                        <h6 class="mb-2 text-dark fw-bold"><i class="fa fa-university me-2 text-warning"></i>1. Transfer to Artist's Account (Artwork Price)</h6>
                                        <?php if ($artist_bank && !empty($artist_bank['bank_name'])): ?>
                                            <table class="table table-borderless table-sm mb-0 small">
                                                <tr>
                                                    <td class="text-muted py-1" style="width: 150px;">Bank:</td>
                                                    <td class="text-dark py-1 fw-semibold"><?= htmlspecialchars($artist_bank['bank_name']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-1">Account Number:</td>
                                                    <td class="text-dark py-1 fw-bold"><?= htmlspecialchars($artist_bank['bank_account']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-1">Account Holder (A/N):</td>
                                                    <td class="text-dark py-1"><?= htmlspecialchars($artist_bank['bank_holder']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted py-1">Transfer Amount:</td>
                                                    <td class="text-success py-1 fw-bold">Rp <?= number_format($artwork['price'], 0, ',', '.'); ?></td>
                                                </tr>
                                            </table>
                                        <?php else: ?>
                                            <span class="text-danger small"><i class="fa fa-exclamation-circle me-1"></i> Artist have not set up their bank details. Please contact Hiranya admin for payment assistance.</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="bank-details-box p-3 mb-4">
                                        <h6 class="mb-2 text-dark fw-bold"><i class="fa fa-university me-2 text-warning"></i>2. Transfer to Hiranya's Account (Service Commission 5%)</h6>
                                        <table class="table table-borderless table-sm mb-0 small">
                                            <tr>
                                                <td class="text-muted py-1" style="width: 150px;">Bank:</td>
                                                <td class="text-dark py-1 fw-semibold">Bank BCA</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Account Number:</td>
                                                <td class="text-dark py-1 fw-bold">123-456-7890</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Account Holder (A/N):</td>
                                                <td class="text-dark py-1">Hiranya Art House</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Transfer Amount:</td>
                                                <td class="text-success py-1 fw-bold">Rp <?= number_format($commission_amount, 0, ',', '.'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="bank-details-box p-3 mb-4">
                                        <h6 class="mb-2 text-dark fw-bold"><i class="fa fa-university me-2 text-warning"></i>Transfer to Hiranya's Account</h6>
                                        <table class="table table-borderless table-sm mb-0 small">
                                            <tr>
                                                <td class="text-muted py-1" style="width: 150px;">Bank:</td>
                                                <td class="text-dark py-1 fw-semibold">Bank BCA</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Account Number:</td>
                                                <td class="text-dark py-1 fw-bold">123-456-7890</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Account Holder (A/N):</td>
                                                <td class="text-dark py-1">Hiranya Art House</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted py-1">Transfer Amount:</td>
                                                <td class="text-success py-1 fw-bold">Rp <?= number_format($amount, 0, ',', '.'); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="bank-details-box p-3 mb-4 text-center">
                                        <h6 class="mb-2 text-dark fw-bold text-start"><i class="fa fa-qrcode me-2 text-warning"></i>3. Instant QR Payment Reference</h6>
                                        <p class="text-muted small text-start">Scan this QR Code using your banking app to verify order details and total transfer amount instantly.</p>
                                        <div id="checkout-qrcode" class="d-inline-block border p-2 bg-white rounded my-2"></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="mt-3">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-dark"><i class="fa fa-file-upload me-2 text-secondary"></i>Upload Proof of Transfer (Format: JPG, PNG, PDF)</label>
                                    <input type="file" name="payment_proof" class="form-control" accept="image/*, application/pdf" required>
                                    <div class="form-text small text-muted">Make sure the transfer proof clearly shows the bank reference number and the recipient's name.</div>
                                </div>
                                <button type="submit" class="btn text-white w-100 py-3" style="background-color:#ab8e5b; font-weight:600; letter-spacing:1px; border-radius:6px;">
                                    <i class="fa fa-check-circle me-1"></i> SUBMIT PAYMENT &amp; CHECKOUT
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
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
        const btnReveal = document.getElementById("btn-reveal-bank");
        const bankDetails = document.getElementById("secure-bank-details");
        if (btnReveal && bankDetails) {
            btnReveal.addEventListener("click", function() {
                bankDetails.classList.toggle("d-none");
                if (bankDetails.classList.contains("d-none")) {
                    btnReveal.innerHTML = '<i class="fa fa-eye me-2"></i> Show Payment Account';
                } else {
                    btnReveal.innerHTML = '<i class="fa fa-eye-slash me-2"></i> Hide Payment Account';
                }
            });
        }
    });
    </script>
    <script src="assets/js/qrcode_helper.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Generate QR code with transfer details
        const orderId = <?= $order_id; ?>;
        const amount = <?= $amount; ?>;
        const qrText = `HIRANYA_ORDER_${orderId}_AMT_${amount}`;
        generateQRCode('checkout-qrcode', qrText, 140, 140);
    });
    </script>
</body>
</html>
