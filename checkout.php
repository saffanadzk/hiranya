<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$artwork_id = isset($_GET['artwork_id']) ? (int)$_GET['artwork_id'] : 0;
$auction_id = isset($_GET['auction_id']) ? (int)$_GET['auction_id'] : 0;

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
    die("Karya seni tidak ditemukan.");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buyer_id = $_SESSION['user_id'];
    $upload_dir = "uploads/";
    $payment_proof = "";

    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        
        if (!in_array($ext, $allowed)) {
            $error = "Format bukti transfer harus JPG, JPEG, PNG, atau PDF.";
        } else {
            $payment_proof = 'proof_' . time() . '_' . uniqid() . '.' . $ext;
            if (!move_uploaded_file($_FILES['payment_proof']['tmp_name'], $upload_dir . $payment_proof)) {
                $error = "Gagal mengunggah bukti transfer.";
            }
        }
    } else {
        $error = "Silakan upload bukti transfer bank Anda.";
    }

    if (!isset($error)) {
        $ins_query = "INSERT INTO orders (artwork_id, buyer_id, order_type, amount, commission_amount, payment_proof, payment_status) VALUES (?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = mysqli_prepare($conn, $ins_query);
        mysqli_stmt_bind_param($stmt, "iisdds", $artwork_id, $buyer_id, $order_type, $amount, $commission_amount, $payment_proof);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Bukti transfer berhasil dikirim! Silakan tunggu verifikasi admin.";
            $_SESSION['message_type'] = "success";
            header("Location: profile.php");
            exit();
        } else {
            $error = "Gagal memproses order: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout Karya Seni - Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        .checkout-card {
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,0.06);
            background: #fff;
        }
        .bank-details-box {
            background-color: #fdfbf7;
            border-left: 4px solid #ab8e5b;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-light">

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

                    <h5 class="mb-3" style="font-family: 'Playfair Display', serif; font-weight:600;">Rincian Pembayaran</h5>
                    <table class="table align-middle mb-4">
                        <tbody>
                            <?php if ($order_type === 'direct'): ?>
                                <tr>
                                    <td class="text-muted">Harga Karya Seni (ke Artist)</td>
                                    <td class="text-end text-dark">Rp <?= number_format($artwork['price'], 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Komisi Layanan Hiranya (5%)</td>
                                    <td class="text-end text-dark">Rp <?= number_format($commission_amount, 0, ',', '.'); ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td class="text-muted">Harga Jual Karya Seni (ke Hiranya)</td>
                                    <td class="text-end text-dark">Rp <?= number_format($amount, 0, ',', '.'); ?></td>
                                </tr>
                            <?php endif; ?>
                            <tr class="table-light fw-bold">
                                <td class="text-dark">Total Pembayaran</td>
                                <td class="text-end text-dark" style="font-size: 18px; color: #ab8e5b !important;">
                                    Rp <?= number_format($amount, 0, ',', '.'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mb-3" style="font-family: 'Playfair Display', serif; font-weight:600;">Instruksi Pembayaran Transfer Bank</h5>
                    <p class="text-secondary small">Harap lakukan transfer sesuai nominal rincian di atas ke rekening berikut:</p>

                    <?php if ($order_type === 'direct'): ?>
                        <div class="bank-details-box p-3 mb-3">
                            <h6 class="mb-2 text-dark fw-bold"><i class="fa fa-university me-2 text-warning"></i>1. Transfer ke Rekening Artist (Harga Karya)</h6>
                            <?php if ($artist_bank && !empty($artist_bank['bank_name'])): ?>
                                <table class="table table-borderless table-sm mb-0 small">
                                    <tr>
                                        <td class="text-muted py-1" style="width: 150px;">Nama Bank:</td>
                                        <td class="text-dark py-1 fw-semibold"><?= htmlspecialchars($artist_bank['bank_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Nomor Rekening:</td>
                                        <td class="text-dark py-1 fw-bold"><?= htmlspecialchars($artist_bank['bank_account']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Atas Nama (A/N):</td>
                                        <td class="text-dark py-1"><?= htmlspecialchars($artist_bank['bank_holder']); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted py-1">Jumlah Transfer:</td>
                                        <td class="text-success py-1 fw-bold">Rp <?= number_format($artwork['price'], 0, ',', '.'); ?></td>
                                    </tr>
                                </table>
                            <?php else: ?>
                                <span class="text-danger small"><i class="fa fa-exclamation-circle me-1"></i> Artist belum menyeting detail rekening bank transfernya. Silakan hubungi artist secara pribadi atau teruskan bukti transfer ke Hiranya.</span>
                            <?php endif; ?>
                        </div>

                        <div class="bank-details-box p-3 mb-4">
                            <h6 class="mb-2 text-dark fw-bold"><i class="fa fa-university me-2 text-warning"></i>2. Transfer ke Rekening Hiranya (Komisi Layanan 5%)</h6>
                            <table class="table table-borderless table-sm mb-0 small">
                                <tr>
                                    <td class="text-muted py-1" style="width: 150px;">Nama Bank:</td>
                                    <td class="text-dark py-1 fw-semibold">Bank Mandiri</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Nomor Rekening:</td>
                                    <td class="text-dark py-1 fw-bold">123-456-7890</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Atas Nama (A/N):</td>
                                    <td class="text-dark py-1">Hiranya Art House</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Jumlah Transfer:</td>
                                    <td class="text-success py-1 fw-bold">Rp <?= number_format($commission_amount, 0, ',', '.'); ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php else: ?>

                        <div class="bank-details-box p-3 mb-4">
                            <h6 class="mb-2 text-dark fw-bold"><i class="fa fa-university me-2 text-warning"></i>Transfer ke Rekening Hiranya</h6>
                            <table class="table table-borderless table-sm mb-0 small">
                                <tr>
                                    <td class="text-muted py-1" style="width: 150px;">Nama Bank:</td>
                                    <td class="text-dark py-1 fw-semibold">Bank Mandiri</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Nomor Rekening:</td>
                                    <td class="text-dark py-1 fw-bold">123-456-7890</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Atas Nama (A/N):</td>
                                    <td class="text-dark py-1">Hiranya Art House</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-1">Jumlah Transfer:</td>
                                    <td class="text-success py-1 fw-bold">Rp <?= number_format($amount, 0, ',', '.'); ?></td>
                                </tr>
                            </table>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Upload Bukti Transfer Bank (Format: JPG, PNG, PDF)</label>
                            <input type="file" name="payment_proof" class="form-control" accept="image/*, application/pdf" required>
                            <div class="form-text small text-muted">Upload gabungan struk bukti transfer atau struk bank utama Anda.</div>
                        </div>

                        <button type="submit" class="btn text-white w-100 py-3" style="background-color:#ab8e5b; font-weight:600; letter-spacing:1px;">SUBMIT PEMBAYARAN &amp; CHECKOUT</button>
                    </form>
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
</body>
</html>
