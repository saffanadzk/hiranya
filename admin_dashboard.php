<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['message'] = "Akses ditolak! Anda harus masuk sebagai admin.";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit;
}

$message = '';
$message_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

$cat_query = mysqli_query($conn, "SELECT * FROM categories ORDER BY name ASC");
$categories = [];
while ($row = mysqli_fetch_assoc($cat_query)) {
    $categories[] = $row;
}

$art_sql = "
    SELECT artworks.*, users.username AS artist_name, categories.name AS category_name
    FROM artworks
    LEFT JOIN users ON artworks.artist_id = users.id
    LEFT JOIN categories ON artworks.category_id = categories.id
    ORDER BY artworks.id DESC
";
$art_res = mysqli_query($conn, $art_sql);

$auc_sql = "
    SELECT auctions.*, artworks.title AS art_title, artworks.image_url, users.username AS artist_name
    FROM auctions
    JOIN artworks ON auctions.artwork_id = artworks.id
    LEFT JOIN users ON artworks.artist_id = users.id
    ORDER BY auctions.id DESC
";
$auc_res = mysqli_query($conn, $auc_sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Panel - Hiranya</title>
    
    <link href="assets/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Playfair+Display:wght@500;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="admin-page">

    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3" style="background-color: #1C2431;">
        <a href="admin_dashboard.php" class="admin-brand me-auto">Hiranya <span style="font-size: 14px; font-family: 'Work Sans', sans-serif; color: #ab8e5b; letter-spacing: 0;">Admin Portal</span></a>
        <div class="d-flex align-items-center">
            <a href="profile.php" class="btn btn-outline-light btn-sm me-2"><i class="fa fa-user"></i>Profil</a>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="fa fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <div class="admin-header text-center">
        <div class="container">
            <h1 class="display-5 mb-2">Administration Panel</h1>
            <p class="lead mb-0 text-muted" style="color: #cbd5e1 !important;">Art Management Admin Panel.</p>
        </div>
    </div>

    <div class="container my-5">

        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $message_type; ?> alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa <?= $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> me-2"></i>
                <?= htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <ul class="nav nav-tabs nav-tabs-custom" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="artworks-tab" data-bs-toggle="tab" data-bs-target="#artworks-pane" type="button" role="tab" aria-controls="artworks-pane" aria-selected="true">
                    <i class="fa fa-palette me-2"></i>Artist's Artwork
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories-pane" type="button" role="tab" aria-controls="categories-pane" aria-selected="false">
                    <i class="fa fa-tags me-2"></i>Manage Categories
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="auctions-tab" data-bs-toggle="tab" data-bs-target="#auctions-pane" type="button" role="tab" aria-controls="auctions-pane" aria-selected="false">
                    <i class="fa fa-gavel me-2"></i>Manage Auctions
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">

            <div class="tab-pane fade show active" id="artworks-pane" role="tabpanel" aria-labelledby="artworks-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Artwork List</h3>
                    <span class="text-muted">Total: <?= mysqli_num_rows($art_res); ?> Artworks </span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Artworks</th>
                                <th>Artist</th>
                                <th>Price</th>
                                <th>Categories</th>
                                <th>Status</th>
                                <th style="width: 250px;">Allocation Action</th>
                                <th>Management</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($art_res) == 0): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No artworks have been uploaded by artists yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php while ($art = mysqli_fetch_assoc($art_res)): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="uploads/<?= htmlspecialchars($art['image_url']); ?>" class="art-thumbnail" alt="Artwork image">
                                                <div>
                                                    <h6 class="mb-1 text-dark"><?= htmlspecialchars($art['title']); ?></h6>
                                                    <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                        <?= htmlspecialchars($art['description']); ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">@<?= htmlspecialchars($art['artist_name']); ?></span>
                                        </td>
                                        <td>
                                            <span class="text-dark">Rp <?= number_format($art['price'], 0, ',', '.'); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-light border px-2 py-1">
                                                <?= $art['category_name'] ? htmlspecialchars($art['category_name']) : 'Uncategorized'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($art['status'] === 'available'): ?>
                                                <span class="badge badge-status badge-available">Available</span>
                                            <?php elseif ($art['status'] === 'sold'): ?>
                                                <span class="badge badge-status badge-sold">Sold</span>
                                            <?php elseif ($art['status'] === 'in_auction'): ?>
                                                <span class="badge badge-status badge-auction">In Auction</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <form action="admin_actions.php?action=assign_category" method="POST" class="d-flex align-items-center gap-1 mb-2">
                                                <input type="hidden" name="artwork_id" value="<?= $art['id']; ?>">
                                                <select name="category_id" class="form-select form-select-sm" style="max-width: 140px;">
                                                    <option value="0">— Categories —</option>
                                                    <?php foreach ($categories as $cat): ?>
                                                        <option value="<?= $cat['id']; ?>" <?= $art['category_id'] == $cat['id'] ? 'selected' : ''; ?>>
                                                            <?= htmlspecialchars($cat['name']); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" class="btn btn-navy btn-sm" title="Save Categories">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                            </form>

                                            <?php if ($art['status'] !== 'in_auction'): ?>
                                                <button type="button" class="btn btn-gold btn-sm w-100" data-bs-toggle="modal" data-bs-target="#auctionModal<?= $art['id']; ?>">
                                                    <i class="fa fa-gavel me-1"></i> Put into Auction
                                                </button>
                                            <?php else: ?>
                                                <a href="admin_actions.php?action=remove_auction&artwork_id=<?= $art['id']; ?>" 
                                                   class="btn btn-outline-danger btn-sm w-100"
                                                   onclick="return confirm('Remove this artwork from the active auction list?')">
                                                    <i class="fa fa-ban me-1"></i> Withdraw from Auctions
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit_artwork_admin.php?id=<?= $art['id']; ?>" class="btn btn-outline-secondary btn-sm" title="Edit Metadata">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="admin_actions.php?action=delete_artwork&id=<?= $art['id']; ?>" 
                                                   class="btn btn-outline-danger btn-sm" 
                                                   title="Delete" 
                                                   onclick="return confirm('Are you sure you want to delete this artwork?')">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php if ($art['status'] !== 'in_auction'): ?>
                                        <div class="modal fade" id="auctionModal<?= $art['id']; ?>" tabindex="-1" aria-labelledby="auctionModalLabel<?= $art['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="admin_actions.php?action=assign_auction" method="POST">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: #1C2431; color: white;">
                                                            <h5 class="modal-title" id="auctionModalLabel<?= $art['id']; ?>">Add Artwork to Auction</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="artwork_id" value="<?= $art['id']; ?>">
                                                            
                                                            <div class="mb-3 text-center">
                                                                <img src="uploads/<?= htmlspecialchars($art['image_url']); ?>" class="img-thumbnail mb-2" style="max-height: 180px;" alt="">
                                                                <h6><?= htmlspecialchars($art['title']); ?></h6>
                                                                <small class="text-muted">oleh @<?= htmlspecialchars($art['artist_name']); ?></small>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Harga Penawaran Awal (Rp)</label>
                                                                <input type="number" name="start_bid" class="form-control" value="<?= $art['price']; ?>" min="0" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Waktu Mulai Lelang</label>
                                                                <input type="datetime-local" name="start_time" class="form-control" value="<?= date('Y-m-d\TH:i'); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Waktu Berakhir Lelang</label>
                                                                <input type="datetime-local" name="end_time" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime('+1 day')); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-gold">Mulai Lelang</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="categories-pane" role="tabpanel" aria-labelledby="categories-tab">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card card-custom">
                            <div class="card-header py-3" style="background-color: #1C2431; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                <h5 class="card-title mb-0">Tambah Kategori Baru</h5>
                            </div>
                            <div class="card-body">
                                <form action="admin_actions.php?action=add_category" method="POST">
                                    <div class="mb-3">
                                        <label for="new_category_name" class="form-label">Nama Kategori</label>
                                        <input type="text" class="form-control" id="new_category_name" name="name" placeholder="Contoh: Modern Art" required>
                                    </div>
                                    <button type="submit" class="btn btn-gold w-100">Tambah Kategori</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <h5 class="mb-3">Daftar Kategori Terdaftar</h5>
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Kategori</th>
                                        <th>Slug URL</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($categories) === 0): ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada kategori terdaftar. Silakan tambahkan kategori baru.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($categories as $cat): ?>
                                            <tr>
                                                <td><?= $cat['id']; ?></td>
                                                <td>
                                                    <span class="fw-semibold text-dark"><?= htmlspecialchars($cat['name']); ?></span>
                                                </td>
                                                <td>
                                                    <code><?= htmlspecialchars($cat['slug']); ?></code>
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editCatModal<?= $cat['id']; ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </button>
                                                    <a href="admin_actions.php?action=delete_category&id=<?= $cat['id']; ?>" 
                                                       class="btn btn-outline-danger btn-sm"
                                                       onclick="return confirm('Hapus kategori ini? Semua karya seni dengan kategori ini akan diset menjadi Uncategorized.')">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editCatModal<?= $cat['id']; ?>" tabindex="-1" aria-labelledby="editCatModalLabel<?= $cat['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="admin_actions.php?action=edit_category" method="POST">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #1C2431; color: white;">
                                                                <h5 class="modal-title" id="editCatModalLabel<?= $cat['id']; ?>">Edit Kategori</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?= $cat['id']; ?>">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama Kategori</label>
                                                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cat['name']); ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-gold">Simpan Perubahan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="auctions-pane" role="tabpanel" aria-labelledby="auctions-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Daftar Lelang Aktif</h3>
                    <span class="text-muted">Total: <?= mysqli_num_rows($auc_res); ?> lelang</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Karya Seni</th>
                                <th>Penawaran Awal</th>
                                <th>Penawaran Saat Ini</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Berakhir</th>
                                <th>Status Lelang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($auc_res) == 0): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">Belum ada karya seni yang sedang dilelang saat ini.</td>
                                </tr>
                            <?php else: ?>
                                <?php while ($auc = mysqli_fetch_assoc($auc_res)): ?>
                                    <tr>
                                        <td>#<?= $auc['id']; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="uploads/<?= htmlspecialchars($auc['image_url']); ?>" class="art-thumbnail" alt="">
                                                <div>
                                                    <h6 class="mb-0"><?= htmlspecialchars($auc['art_title']); ?></h6>
                                                    <small class="text-muted">oleh @<?= htmlspecialchars($auc['artist_name']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span>Rp <?= number_format($auc['start_bid'], 0, ',', '.'); ?></span>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-success">Rp <?= number_format($auc['current_bid'], 0, ',', '.'); ?></span>
                                        </td>
                                        <td>
                                            <small><?= date('d M Y, H:i', strtotime($auc['start_time'])); ?></small>
                                        </td>
                                        <td>
                                            <small><?= date('d M Y, H:i', strtotime($auc['end_time'])); ?></small>
                                        </td>
                                        <td>
                                            <?php 
                                            $now = date('Y-m-d H:i:s');
                                            if ($now < $auc['start_time']): 
                                            ?>
                                                <span class="badge text-bg-warning text-white">Segera Mulai</span>
                                            <?php elseif ($now > $auc['end_time'] || $auc['status'] === 'ended'): ?>
                                                <span class="badge text-bg-secondary">Berakhir</span>
                                            <?php else: ?>
                                                <span class="badge text-bg-success">Aktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="admin_actions.php?action=remove_auction&artwork_id=<?= $auc['artwork_id']; ?>" 
                                               class="btn btn-outline-danger btn-sm"
                                               onclick="return confirm('Hapus lelang ini?')">
                                                <i class="fa fa-trash me-1"></i> Batal Lelang
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        
    </div>

    <div class="container-fluid footer bg-dark text-white-50 py-5 mt-5">
        <div class="container py-4 text-center">
            <p class="mb-0">&copy; Hiranya Art House. All Rights Reserved.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('button[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('id'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#' + activeTab).tab('show');
            }
        });
    </script>
</body>
</html>
