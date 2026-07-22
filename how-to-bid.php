<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Cara Mengikuti Lelang | Hiranya Art House</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="Panduan dan tutorial lengkap cara mengikuti lelang karya seni di Hiranya Art House.">
    
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/dark_mode.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        .hero-section {
            background: linear-gradient(135deg, #1C2431 0%, #0F172A 100%);
            color: #ffffff;
            padding: 80px 0 60px;
            border-bottom: 3px solid #AB8E5B;
        }
        .gold-badge {
            background-color: #AB8E5B;
            color: #ffffff;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-block;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        .step-card {
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            border-color: #AB8E5B;
        }
        .step-number {
            width: 50px;
            height: 50px;
            background-color: #1C2431;
            color: #AB8E5B;
            font-weight: 800;
            font-size: 1.3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #AB8E5B;
        }
        .rule-box {
            background-color: rgba(171, 142, 91, 0.08);
            border: 1px solid rgba(171, 142, 91, 0.25);
            border-radius: 12px;
            padding: 20px;
        }
        .dark-mode .step-card {
            background-color: #1E293B !important;
            border-color: #334155 !important;
        }
        .dark-mode .step-number {
            background-color: #0F172A !important;
        }
        .dark-mode .rule-box {
            background-color: rgba(171, 142, 91, 0.15) !important;
        }
    </style>
</head>
<body class="<?= $theme_class; ?>">

    <!-- Navigation Header -->
    <?php include 'partials/navbar.php'; ?>

    <!-- Hero Header -->
    <div class="hero-section text-center">
        <div class="container py-4">
            <span class="gold-badge mb-3"><i class="fa fa-gavel me-2"></i>Panduan Kolektor</span>
            <h1 class="display-4 fw-bold text-white mb-3">Cara Mengikuti Lelang Karya Seni</h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 700px;">
                Selamat datang di Hiranya Art House. Ikuti panduan mudah 5 langkah di bawah ini untuk berpartisipasi dalam lelang karya seni eksklusif secara aman dan transparan.
            </p>
        </div>
    </div>

    <!-- Main Tutorial Content -->
    <div class="container py-5">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark mb-2">5 Langkah Mudah Mengikuti Lelang</h2>
            <p class="text-muted">Proses cepat dan otomatis dari penawaran awal hingga kemenangan karya seni Anda.</p>
        </div>

        <div class="row g-4">
            
            <!-- Step 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">1</div>
                        <i class="fa fa-user-plus fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Registrasi & Login Akun</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Buat akun gratis Anda di Hiranya Art House atau login ke akun yang sudah ada. Pastikan alamat email dan nomor telepon terverifikasi untuk menerima kabar pemenang lelang.
                    </p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">2</div>
                        <i class="fa fa-compass fa-2x text-primary"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Jelajahi Katalog Lelang</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Buka menu <strong>AUCTIONS &rarr; Current Auctions</strong> untuk melihat daftar karya seni spektakuler dari para seniman ternama yang saat ini sedang dalam masa penawaran aktif.
                    </p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">3</div>
                        <i class="fa fa-clock fa-2x text-danger"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Periksa Detail & Timer</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Klik karya seni pilihan Anda untuk melihat detail ukuran, teknik pembuatan, sertifikat keaslian, harga penawaran awal (Starting Bid), serta waktu mundur lelang (Countdown Timer).
                    </p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="col-lg-4 col-md-6 ms-lg-auto">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">4</div>
                        <i class="fa fa-hand-holding-usd fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Kirim Penawaran (Place Bid)</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Masukkan nominal penawaran Anda (harus lebih tinggi dari penawaran saat ini + kelipatan bid). Klik <strong>Place Bid</strong>. Penawaran Anda akan langsung terekam real-time!
                    </p>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="col-lg-4 col-md-6 me-lg-auto">
                <div class="step-card bg-white p-4 h-100 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="step-number">5</div>
                        <i class="fa fa-trophy fa-2x text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Menangkan & Bayar Pesanan</h5>
                    <p class="text-muted small mb-0 flex-grow-1">
                        Jika Anda menjadi penawar tertinggi saat hitung mundur berakhir, Anda dinyatakan sebagai pemenang! Selesaikan pembayaran melalui transfer bank/QRIS dalam waktu 1x24 jam.
                    </p>
                </div>
            </div>

        </div>

        <!-- Rules & Safeguards Section -->
        <div class="my-5 p-4 bg-white shadow-sm rounded-4 border">
            <h4 class="fw-bold text-dark mb-3"><i class="fa fa-shield-alt text-warning me-2"></i>Aturan Penting & Ketentuan Lelang</h4>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="rule-box h-100">
                        <h6 class="fw-bold text-dark mb-1"><i class="fa fa-check-circle me-2 text-success"></i>Penawaran Binding (Mengikat)</h6>
                        <p class="text-muted small mb-0">
                            Setiap bid yang Anda kirimkan bersifat mengikat secara hukum. Pastikan Anda memeriksa detail karya sebelum menawar.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rule-box h-100">
                        <h6 class="fw-bold text-dark mb-1"><i class="fa fa-clock me-2 text-primary"></i>Perpanjangan Otomatis (Soft Close)</h6>
                        <p class="text-muted small mb-0">
                            Jika terdapat penawaran di 2 menit terakhir lelang, timer akan otomatis diperpanjang 3 menit untuk memberikan kesempatan adil kepada semua penawar.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="my-5">
            <h3 class="fw-bold text-dark text-center mb-4">Pertanyaan Sering Diajukan (FAQ)</h3>
            
            <div class="accordion shadow-sm rounded-3 overflow-hidden" id="faqAccordion">
                
                <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Bagaimana jika penawaran saya dilewati oleh peserta lain?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Jika ada peserta lain yang menawar dengan nominal lebih tinggi, Anda akan menerima pemberitahuan di akun Anda. Anda dapat kembali mengajukan tawaran baru yang lebih tinggi selama waktu lelang masih berjalan.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Metode pembayaran apa saja yang didukung?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Kami mendukung Transfer Bank Resmi (BCA, Bank Mandiri, BNI), QRIS, serta Kartu Kredit melalui saluran pembayaran terverifikasi Hiranya Art House.
                        </div>
                    </div>
                </div>

                <div class="accordion-item border-0">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed fw-bold text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Bagaimana pengiriman karya seni setelah menang lelang?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Setelah pembayaran Anda diverifikasi oleh tim kurator kami, karya seni akan dikemas secara profesional sesuai standar perlindungan museum dan dikirim langsung ke alamat tujuan Anda beserta Sertifikat Keaslian (Certificate of Authenticity).
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center my-5 py-4 bg-dark text-white rounded-4 p-4 shadow">
            <h3 class="fw-bold mb-2">Siap Menambah Koleksi Karya Seni Anda?</h3>
            <p class="text-white-50 mb-4">Temukan berbagai lukisan dan karya mahakarya kurasi terbaik yang sedang dilelang hari ini.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="auction.php" class="btn btn-warning btn-lg px-4 fw-bold">
                    <i class="fa fa-gavel me-2"></i>Lihat Lelang Aktif
                </a>
                <a href="auction-results.php" class="btn btn-outline-light btn-lg px-4">
                    <i class="fa fa-history me-2"></i>Hasil Lelang Sebelumnya
                </a>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="container-fluid footer bg-dark text-white-50 py-5 mt-5">
        <div class="container py-4 text-center">
            <p class="mb-0">&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
