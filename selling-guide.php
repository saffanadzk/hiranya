<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Selling Guide | Hiranya House</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/discover.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@400;500;700&family=Work+Sans:wght@300;400;500&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <style>
        body.discover-page { background: #fcfaf7 !important; }

        .sg-hero {
            background: #1C2431;
            padding: 70px 0 60px;
            text-align: center;
        }
        .sg-hero-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #ab8e5b;
            display: block;
            margin-bottom: 14px;
        }
        .sg-hero h1 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 42px;
            margin-bottom: 14px;
        }
        .sg-hero p {
            color: rgba(255,255,255,0.65);
            font-size: 16px;
            max-width: 560px;
            margin: 0 auto;
        }

        /* Notice box: harus register as artist */
        .sg-notice {
            background: rgba(171, 142, 91, 0.1);
            border: 1.5px solid #ab8e5b;
            border-radius: 10px;
            padding: 24px 30px;
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }
        .sg-notice-icon {
            font-size: 24px;
            color: #ab8e5b;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .sg-notice h5 {
            font-family: 'Playfair Display', serif;
            color: #1C2431;
            font-size: 18px;
            margin-bottom: 6px;
        }
        .sg-notice p {
            color: #555;
            font-size: 14px;
            margin: 0;
        }
        .sg-notice a {
            color: #ab8e5b;
            font-weight: 700;
        }

        /* Process steps */
        .sg-step {
            display: flex;
            gap: 28px;
            padding: 36px 0;
            border-bottom: 1px solid #ece7dc;
            align-items: flex-start;
        }
        .sg-step:last-child { border-bottom: none; }

        .sg-step-num {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #1C2431;
            color: #e8c97a;
            font-family: 'Cinzel', serif;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sg-step-content h4 {
            font-family: 'Playfair Display', serif;
            color: #1C2431;
            font-size: 20px;
            margin-bottom: 8px;
        }
        .sg-step-content p {
            color: #555;
            font-size: 14.5px;
            line-height: 1.7;
            margin-bottom: 10px;
        }
        .sg-step-tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 4px 12px;
            border-radius: 20px;
            background: rgba(171, 142, 91, 0.12);
            color: #ab8e5b;
            border: 1px solid rgba(171, 142, 91, 0.3);
        }

        /* Key rules */
        .sg-rule-card {
            background: #fff;
            border: 1px solid #ece7dc;
            border-radius: 10px;
            padding: 26px;
            height: 100%;
        }
        .sg-rule-icon {
            font-size: 22px;
            color: #ab8e5b;
            margin-bottom: 12px;
        }
        .sg-rule-card h6 {
            font-family: 'Playfair Display', serif;
            color: #1C2431;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .sg-rule-card p {
            color: #666;
            font-size: 13.5px;
            margin: 0;
            line-height: 1.6;
        }

        /* CTA bottom */
        .sg-cta {
            background: #1C2431;
            border-radius: 12px;
            padding: 50px 40px;
            text-align: center;
        }
        .sg-cta h3 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 26px;
            margin-bottom: 12px;
        }
        .sg-cta p {
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            margin-bottom: 24px;
        }
        .sg-cta-btn {
            display: inline-block;
            background: #ab8e5b;
            color: #fff;
            padding: 13px 34px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-decoration: none;
            border-radius: 3px;
            transition: background .25s;
        }
        .sg-cta-btn:hover { background: #927546; color: #fff; }
    </style>
</head>
<body class="discover-page">

    <?php include 'partials/navbar.php'; ?>

    <!-- Hero -->
    <div class="sg-hero">
        <span class="sg-hero-eyebrow">SELL WITH HIRANYA</span>
        <h1>Selling Guide</h1>
        <p>Everything you need to know about bringing your artwork to the right collectors through Hiranya Art House.</p>
    </div>

    <div class="container py-5">

        <!-- PENTING: harus register as artist -->
        <div class="sg-notice mb-5">
            <div class="sg-notice-icon"><i class="fa fa-info-circle"></i></div>
            <div>
                <h5>Syarat Utama: Daftar sebagai Artist</h5>
                <p>Semua jalur penjualan di Hiranya — Submit Artwork, Request Valuation, Sell at Auction, maupun Sell via Private Sales — hanya tersedia untuk akun yang terdaftar sebagai <strong>Artist</strong>. Jika Anda belum punya akun Artist, <a href="register.php">daftar di sini</a> dan pilih role <strong>"Artist"</strong> saat registrasi.</p>
            </div>
        </div>

        <!-- 4 jalur jual -->
        <h2 class="font-playfair-display mb-2" style="color:#1C2431;">Cara Menjual di Hiranya</h2>
        <p class="text-muted mb-4" style="font-size:15px;">Ada 4 jalur yang bisa Anda pilih sesuai kebutuhan:</p>

        <div class="sg-steps">

            <div class="sg-step">
                <div class="sg-step-num">1</div>
                <div class="sg-step-content">
                    <h4>Submit Artwork</h4>
                    <p>Unggah karya seni Anda beserta judul, deskripsi, dan harga yang Anda inginkan. Tim Hiranya akan meninjaunya dan memberikan keputusan Approved atau Rejected dalam 3–5 hari kerja. Setelah disetujui, karya Anda akan tampil di galeri publik dan bisa dilihat oleh kolektor.</p>
                    <span class="sg-step-tag">BUTUH: Akun Artist</span>
                    <a href="submit_artwork.php" class="btn btn-sm ms-2" style="background:#1C2431; color:#fff; font-size:12px; letter-spacing:1px;">SUBMIT SEKARANG</a>
                </div>
            </div>

            <div class="sg-step">
                <div class="sg-step-num">2</div>
                <div class="sg-step-content">
                    <h4>Request Valuation</h4>
                    <p>Tidak yakin berapa harga yang tepat untuk karya Anda? Ajukan permintaan valuasi kepada tim spesialis Hiranya. Kami akan mengevaluasi provenance, kondisi, dan permintaan pasar saat ini untuk memberikan estimasi harga yang akurat — tanpa biaya.</p>
                    <span class="sg-step-tag">BUTUH: Akun Artist</span>
                    <span class="sg-step-tag ms-1" style="background:rgba(28,36,49,0.08); color:#1C2431; border-color:rgba(28,36,49,0.2);">Segera Hadir</span>
                </div>
            </div>

            <div class="sg-step">
                <div class="sg-step-num">3</div>
                <div class="sg-step-content">
                    <h4>Sell at Auction</h4>
                    <p>Ingin karya Anda masuk ke lelang Hiranya? Prosesnya adalah: karya Anda harus <strong>disubmit dan disetujui (Approved)</strong> terlebih dahulu, lalu <strong>dibeli oleh Hiranya</strong> — artinya Hiranya membayar karya Anda di muka dengan harga yang disepakati, dan Hiranya yang memasukkannya ke lelang dengan harga jual yang lebih tinggi. Keuntungan lelang menjadi milik Hiranya.</p>
                    <div class="mt-2 p-3 rounded" style="background: rgba(139,0,0,0.05); border-left: 3px solid #8b0000;">
                        <small class="text-danger fw-bold"><i class="fa fa-exclamation-triangle me-1"></i> Catatan Penting:</small>
                        <small class="d-block text-muted mt-1">Karya tidak bisa langsung masuk lelang tanpa melalui proses pembelian oleh Hiranya. Ini untuk menjaga kualitas dan kepercayaan kolektor di platform kami.</small>
                    </div>
                    <span class="sg-step-tag mt-2 d-inline-block">BUTUH: Akun Artist + Approved + Dibeli Hiranya</span>
                </div>
            </div>

            <div class="sg-step">
                <div class="sg-step-num">4</div>
                <div class="sg-step-content">
                    <h4>Sell via Private Sales</h4>
                    <p>Setelah karya Anda Approved, kolektor bisa langsung membeli karya Anda melalui profil Artist Anda di halaman "Buy Privately" — tanpa harus menunggu lelang. Kolektor membayar harga yang Anda tentukan, ditambah komisi layanan Hiranya sebesar 5%. Pembayaran dikirim ke rekening bank yang Anda daftarkan di profil Artist Anda.</p>
                    <span class="sg-step-tag">BUTUH: Akun Artist + Approved + Profil Bank Terisi</span>
                </div>
            </div>

        </div>

        <!-- Key rules -->
        <h3 class="font-playfair-display mt-5 mb-4" style="color:#1C2431; font-size:22px;">Aturan & Ketentuan Penting</h3>
        <div class="row g-4 mb-5">
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-user-check"></i></div>
                    <h6>Harus Terdaftar sebagai Artist</h6>
                    <p>Akun Customer tidak bisa submit karya atau berjualan. Daftar ulang sebagai Artist jika Anda sudah punya akun Customer.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-check-circle"></i></div>
                    <h6>Karya Harus Disetujui Admin</h6>
                    <p>Setiap karya yang disubmit akan direview. Hanya karya dengan status "Approved" yang akan tampil di galeri dan bisa dijual.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-gavel"></i></div>
                    <h6>Lelang Hanya Lewat Hiranya</h6>
                    <p>Untuk masuk lelang, karya harus dibeli Hiranya terlebih dahulu. Artist tidak bisa langsung memasukkan karya ke daftar lelang.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="sg-rule-card">
                    <div class="sg-rule-icon"><i class="fa fa-percentage"></i></div>
                    <h6>Komisi Layanan 5%</h6>
                    <p>Untuk transaksi private sale langsung antara Artist dan Kolektor, Hiranya mengambil komisi 5% dari harga karya sebagai biaya layanan platform.</p>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="sg-cta">
            <h3>Siap untuk Mulai?</h3>
            <p>Daftarkan diri Anda sebagai Artist dan mulai submit karya pertama Anda hari ini.</p>
            <a href="register.php" class="sg-cta-btn">DAFTAR SEBAGAI ARTIST</a>
        </div>

    </div>

    <div class="container-fluid footer position-relative bg-dark text-white-50 py-5 mt-5">
        <div class="container py-4 text-center">
            <p>&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>