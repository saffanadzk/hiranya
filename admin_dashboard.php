<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['message'] = "Access denied! Admin Login required.";
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

$orders_sql = "
    SELECT orders.*, artworks.title AS art_title, artworks.image_url, buyers.username AS buyer_name, artists.username AS artist_name
    FROM orders
    JOIN artworks ON orders.artwork_id = artworks.id
    JOIN users AS buyers ON orders.buyer_id = buyers.id
    LEFT JOIN users AS artists ON artworks.artist_id = artists.id
    ORDER BY orders.id DESC
";
$orders_res = mysqli_query($conn, $orders_sql);

// Analytics Queries
$sales_query = mysqli_query($conn, "
    SELECT DATE_FORMAT(created_at, '%b %Y') as month, 
           SUM(amount) as total_sales, 
           SUM(commission_amount) as total_commission
    FROM orders 
    WHERE payment_status = 'verified'
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)
");
$sales_data = [];
while ($row = mysqli_fetch_assoc($sales_query)) {
    $sales_data[] = $row;
}

$category_dist_query = mysqli_query($conn, "
    SELECT categories.name, COUNT(artworks.id) as artwork_count
    FROM categories
    LEFT JOIN artworks ON categories.id = artworks.category_id
    GROUP BY categories.id
");
$category_dist = [];
while ($row = mysqli_fetch_assoc($category_dist_query)) {
    $category_dist[] = $row;
}

$auction_activity_query = mysqli_query($conn, "
    SELECT artworks.title, COUNT(bids.id) as bid_count
    FROM auctions
    JOIN artworks ON auctions.artwork_id = artworks.id
    LEFT JOIN bids ON auctions.id = bids.auction_id
    WHERE auctions.status = 'active'
    GROUP BY auctions.id
    LIMIT 10
");
$auction_activity = [];
while ($row = mysqli_fetch_assoc($auction_activity_query)) {
    $auction_activity[] = $row;
}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="admin-page">

    <nav class="navbar navbar-expand-lg navbar-dark px-4 py-3" style="background-color: #1C2431;">
        <a href="admin_dashboard.php" class="admin-brand me-auto">Hiranya <span style="font-size: 14px; font-family: 'Work Sans', sans-serif; color: #ab8e5b; letter-spacing: 20; display: flex; align-items: center; gap: 15px">Admin Portal</span></a>
        <div class="d-flex align-items-center">
            <a href="profile.php" class="btn btn-outline-light btn-sm me-2"><i class="fa fa-user"></i>Profile</a>
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
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: '<?= htmlspecialchars($message_type == 'success' ? 'Success' : 'Notification'); ?>',
                    text: '<?= htmlspecialchars($message); ?>',
                    icon: '<?= $message_type == 'danger' ? 'error' : ($message_type == 'success' ? 'success' : 'info'); ?>',
                    confirmButtonColor: '#ab8e5b'
                });
            });
            </script>
        <?php endif; 
        ?>

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
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders-pane" type="button" role="tab" aria-controls="orders-pane" aria-selected="false">
                    <i class="fa fa-receipt me-2"></i>Payment Verifications
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics-pane" type="button" role="tab" aria-controls="analytics-pane" aria-selected="false">
                    <i class="fa fa-chart-line me-2"></i>Analytics & Reports
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup-pane" type="button" role="tab" aria-controls="backup-pane" aria-selected="false">
                    <i class="fa fa-database me-2"></i>System Backup
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">

            <div class="tab-pane fade show active" id="artworks-pane" role="tabpanel" aria-labelledby="artworks-tab">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <h3 class="mb-0">Artwork List</h3>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-gold btn-sm" data-bs-toggle="modal" data-bs-target="#uploadPrivateModal">
                            <i class="fa fa-plus me-1"></i> Upload Private Collection
                        </button>
                        <span class="text-muted">Total: <?= mysqli_num_rows($art_res); ?> Artworks </span>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Artworks</th>
                                <th>Artist</th>
                                <th>Price</th>
                                <th>Categories</th>
                                <th>Status / Owner</th>
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
                                            
                                            <div class="mt-1">
                                                <?php if ($art['is_purchased_by_hiranya']): ?>
                                                    <span class="badge bg-success text-white">Owned Hiranya</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary text-white">Owned Artist</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($art['is_purchased_by_hiranya']): ?>
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

                                                <?php if ($art['status'] !== 'in_auction' && $art['status'] !== 'sold'): ?>
                                                    <button type="button" class="btn btn-gold btn-sm w-100" data-bs-toggle="modal" data-bs-target="#auctionModal<?= $art['id']; ?>">
                                                        <i class="fa fa-gavel me-1"></i> Put into Auction
                                                    </button>
                                                <?php elseif ($art['status'] === 'in_auction'): ?>
                                                    <a href="admin_actions.php?action=remove_auction&artwork_id=<?= $art['id']; ?>" 
                                                       class="btn btn-outline-danger btn-sm w-100 btn-delete-swal"
                                                       data-confirm-text="Remove this artwork from the active auction list?">
                                                        <i class="fa fa-ban me-1"></i> Withdraw from Auctions
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">Sold</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#buyModal<?= $art['id']; ?>">
                                                    <i class="fa fa-shopping-cart me-1"></i> Buy for Hiranya
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="edit_artwork_admin.php?id=<?= $art['id']; ?>" class="btn btn-outline-secondary btn-sm" title="Edit Metadata">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="admin_actions.php?action=delete_artwork&id=<?= $art['id']; ?>" 
                                                   class="btn btn-outline-danger btn-sm btn-delete-swal" 
                                                   title="Delete" 
                                                   data-confirm-text="Are you sure you want to delete this artwork?">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php if (!$art['is_purchased_by_hiranya']): ?>
                                        <div class="modal fade" id="buyModal<?= $art['id']; ?>" tabindex="-1" aria-labelledby="buyModalLabel<?= $art['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="admin_actions.php?action=buy_artwork" method="POST">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: #1C2431; color: white;">
                                                            <h5 class="modal-title" id="buyModalLabel<?= $art['id']; ?>">Buy Artwork for Artist</h5>
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
                                                                <label class="form-label">Price from Artist (Rp)</label>
                                                                <input type="text" class="form-control bg-light" value="Rp <?= number_format($art['price'], 0, ',', '.'); ?>" readonly>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Price from hiranya (Rp)</label>
                                                                <input type="number" name="hiranya_price" class="form-control" value="<?= $art['price']; ?>" min="0" required>
                                                                <div class="form-text">Enter the selling price for private sale or auction</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Buy</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($art['is_purchased_by_hiranya'] && $art['status'] !== 'in_auction'): ?>
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
                                                                <label class="form-label">Auction Type</label>
                                                                <select name="auction_type" class="form-select" required>
                                                                    <option value="online">Online Auction</option>
                                                                    <option value="live">Live Auction</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label">Starting Bid (Rp)</label>
                                                                <input type="number" name="start_bid" class="form-control" value="<?= $art['price']; ?>" min="0" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Start Time</label>
                                                                <input type="datetime-local" name="start_time" class="form-control" value="<?= date('Y-m-d\TH:i'); ?>" required>
                                                            </div>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">End Time</label>
                                                                <input type="datetime-local" name="end_time" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime('+3 days')); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-gold">Start Auction</button>
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

                <div class="modal fade" id="uploadPrivateModal" tabindex="-1" aria-labelledby="uploadPrivateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="admin_actions.php?action=upload_private_artwork" method="POST" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #1C2431; color: white;">
                                    <h5 class="modal-title" id="uploadPrivateModalLabel">Upload Private Collection Artwork</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="private_title" class="form-label">Artwork Title</label>
                                        <input type="text" class="form-control" id="private_title" name="title" placeholder="e.g. Indonesian Sunset" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="private_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="private_description" name="description" rows="3" placeholder="Tell the story behind the artwork..."></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="private_price" class="form-label">Value / Price (Rp)</label>
                                        <input type="number" class="form-control" id="private_price" name="price" min="0" required placeholder="e.g. 5000000">
                                    </div>
                                    <div class="mb-3">
                                        <label for="private_category" class="form-label">Category</label>
                                        <select class="form-select" id="private_category" name="category_id">
                                            <option value="0">— Select Category —</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="private_image" class="form-label">Artwork Image File</label>
                                        <input class="form-control" type="file" id="private_image" name="artwork_image" accept="image/*" required>
                                        <div class="form-text">Allowed formats: JPG, PNG, WEBP.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-gold">Upload Artwork</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="categories-pane" role="tabpanel" aria-labelledby="categories-tab">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card card-custom">
                            <div class="card-header py-3" style="background-color: #1C2431; color: white; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                <h5 class="card-title mb-0">Add New Categories</h5>
                            </div>
                            <div class="card-body">
                                <form action="admin_actions.php?action=add_category" method="POST">
                                    <div class="mb-3">
                                        <label for="new_category_name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="new_category_name" name="name" placeholder="Contoh: Modern Art" required>
                                    </div>
                                    <button type="submit" class="btn btn-gold w-100">Add Category</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <h5 class="mb-3">Listed Categories</h5>
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Slug URL</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($categories) === 0): ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">There are no listed categories. Please add new categories.</td>
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
                                                       class="btn btn-outline-danger btn-sm btn-delete-swal"
                                                       data-confirm-text="Delete category? All artworks in this category will be set to Uncategorized.">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editCatModal<?= $cat['id']; ?>" tabindex="-1" aria-labelledby="editCatModalLabel<?= $cat['id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="admin_actions.php?action=edit_category" method="POST">
                                                        <div class="modal-content">
                                                            <div class="modal-header" style="background-color: #1C2431; color: white;">
                                                                <h5 class="modal-title" id="editCatModalLabel<?= $cat['id']; ?>">Edit Category</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?= $cat['id']; ?>">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Category Name</label>
                                                                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cat['name']); ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
                    <h3 class="mb-0">Active Auctions</h3>
                    <span class="text-muted">Total: <?= mysqli_num_rows($auc_res); ?> auctions</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Artworks</th>
                                <th>Starting Price</th>
                                <th>Current Bid</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Auction Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($auc_res) == 0): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">There are no artworks currently being auctioned.</td>
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
                                                    <small class="text-muted">by @<?= htmlspecialchars($auc['artist_name']); ?></small>
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
                                                <span class="badge text-bg-warning text-white">Starting</span>
                                            <?php elseif ($now > $auc['end_time'] || $auc['status'] === 'ended'): ?>
                                                <span class="badge text-bg-secondary">Ended</span>
                                            <?php else: ?>
                                                <span class="badge text-bg-success">Active</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="admin_actions.php?action=remove_auction&artwork_id=<?= $auc['artwork_id']; ?>" 
                                               class="btn btn-outline-danger btn-sm btn-delete-swal"
                                               data-confirm-text="Cancel this auction?">
                                                <i class="fa fa-trash me-1"></i> Cancel Auction
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="orders-pane" role="tabpanel" aria-labelledby="orders-tab">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Payment Verification</h3>
                    <span class="text-muted">Total: <?= mysqli_num_rows($orders_res); ?> Transactions</span>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Artworks</th>
                                <th>Transaction Type</th>
                                <th>Total Payment</th>
                                <th>Buyer & Artist</th>
                                <th>Proof of Transfer</th>
                                <th>Status</th>
                                <th>Verificationth>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($orders_res) == 0): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">There are no transactions pending verification.</td>
                                </tr>
                            <?php else: ?>
                                <?php while ($ord = mysqli_fetch_assoc($orders_res)): ?>
                                    <tr>
                                        <td>#<?= $ord['id']; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="uploads/<?= htmlspecialchars($ord['image_url']); ?>" class="art-thumbnail" style="width: 40px; height: 40px; object-fit: cover;" alt="">
                                                <div>
                                                    <h6 class="mb-0 small text-dark"><?= htmlspecialchars($ord['art_title']); ?></h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($ord['order_type'] === 'direct'): ?>
                                                <span class="badge text-bg-warning text-white">Direct Artist Sale</span>
                                            <?php elseif ($ord['order_type'] === 'private_sale'): ?>
                                                <span class="badge text-bg-info text-white">Private Sale</span>
                                            <?php elseif ($ord['order_type'] === 'auction'): ?>
                                                <span class="badge text-bg-primary text-white">Auction Win</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">Rp <?= number_format($ord['amount'], 0, ',', '.'); ?></span>
                                            <?php if ($ord['commission_amount'] > 0): ?>
                                                <div class="small text-muted font-monospace" style="font-size:10px;">(Hiranya Fee: Rp <?= number_format($ord['commission_amount'], 0, ',', '.'); ?>)</div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small class="d-block text-dark">Buyer: @<?= htmlspecialchars($ord['buyer_name']); ?></small>
                                            <?php if ($ord['order_type'] === 'direct'): ?>
                                                <small class="d-block text-muted">Artist: @<?= htmlspecialchars($ord['artist_name']); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($ord['payment_proof'])): ?>
                                                <a href="uploads/<?= htmlspecialchars($ord['payment_proof']); ?>" target="_blank" class="btn btn-outline-secondary btn-xs p-1 px-2 font-monospace" style="font-size: 11px;">
                                                    <i class="fa fa-image me-1"></i> Proof Transfer
                                                </a>
                                            <?php else: ?>
                                                <span class="text-danger small">No Uploaded</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($ord['payment_status'] === 'pending'): ?>
                                                <span class="badge text-bg-warning text-white">Pending</span>
                                            <?php elseif ($ord['payment_status'] === 'verified'): ?>
                                                <span class="badge text-bg-success">Verified</span>
                                            <?php else: ?>
                                                <span class="badge text-bg-danger">Rejected</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($ord['payment_status'] === 'pending' && !empty($ord['payment_proof'])): ?>
                                                <div class="d-flex gap-1">
                                                    <form action="admin_actions.php?action=verify_payment" method="POST" class="d-inline">
                                                        <input type="hidden" name="order_id" value="<?= $ord['id']; ?>">
                                                        <input type="hidden" name="status" value="verified">
                                                        <button type="button" class="btn btn-success btn-sm p-1 px-2 text-white btn-confirm-submit-swal" data-confirm-text="Verifikasi pembayaran ini?">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="admin_actions.php?action=verify_payment" method="POST" class="d-inline">
                                                        <input type="hidden" name="order_id" value="<?= $ord['id']; ?>">
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="button" class="btn btn-danger btn-sm p-1 px-2 text-white btn-confirm-submit-swal" data-confirm-text="Tolak pembayaran ini?">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted small">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Analytics Pane -->
            <div class="tab-pane fade" id="analytics-pane" role="tabpanel" aria-labelledby="analytics-tab">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h3 class="mb-0 text-dark">Analytics & Interactive Reports</h3>
                    <a href="admin_export.php" class="btn btn-gold btn-sm"><i class="fa fa-file-excel me-1"></i> Export Complete Sales Report (.xlsx)</a>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm p-4 bg-white chart-container">
                            <h5 class="mb-3 text-dark fw-bold">Sales & Commissions Trend</h5>
                            <div style="height: 300px; position: relative;">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm p-4 bg-white chart-container">
                            <h5 class="mb-3 text-dark fw-bold">Artwork Distribution</h5>
                            <div style="height: 300px; position: relative;">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-4 bg-white chart-container">
                            <h5 class="mb-3 text-dark fw-bold">Active Auction Bids Activity</h5>
                            <div style="height: 250px; position: relative;">
                                <canvas id="auctionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Pane -->
            <div class="tab-pane fade" id="backup-pane" role="tabpanel" aria-labelledby="backup-tab">
                <h3 class="mb-4 text-dark">System Backup & Utilities</h3>
                
                <?php if (isset($_GET['restore_success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i> <strong>Success!</strong> Database has been restored successfully from the SQL file.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['restore_error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-triangle me-2"></i> <strong>Import Error:</strong> <?php echo htmlspecialchars($_GET['restore_error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <!-- Database Backup (Export) -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm p-4 bg-white h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-primary-subtle p-3 rounded-circle text-primary" style="background-color: rgba(13, 110, 253, 0.1) !important; width: 55px; height: 55px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-database fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark fw-bold" style="font-size: 1rem;">Database Backup</h5>
                                    <p class="text-muted small mb-0">Export structural SQL snapshot of database tables.</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-auto pt-2 border-top border-light-subtle">
                                <span class="text-muted small">Target DB: <strong>hiranya</strong></span>
                                <a href="admin_backup.php" class="btn btn-navy btn-sm"><i class="fa fa-download me-1"></i> Download SQL</a>
                            </div>
                        </div>
                    </div>

                    <!-- Database Restore (Import) -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm p-4 bg-white h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-warning-subtle p-3 rounded-circle text-warning" style="background-color: rgba(255, 193, 7, 0.15) !important; width: 55px; height: 55px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-upload fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark fw-bold" style="font-size: 1rem;">Import / Restore SQL</h5>
                                    <p class="text-muted small mb-0">Upload a `.sql` file to restore database tables.</p>
                                </div>
                            </div>
                            <div class="mt-auto pt-2 border-top border-light-subtle">
                                <form action="admin_restore.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group input-group-sm">
                                        <input type="file" name="sql_file" class="form-control" accept=".sql" required>
                                        <button class="btn btn-warning btn-sm" type="submit"><i class="fa fa-upload me-1"></i> Restore</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Excel Export -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card border-0 shadow-sm p-4 bg-white h-100">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success-subtle p-3 rounded-circle text-success" style="background-color: rgba(25, 135, 84, 0.1) !important; width: 55px; height: 55px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-file-excel fa-lg"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1 text-dark fw-bold" style="font-size: 1rem;">Export Excel Report</h5>
                                    <p class="text-muted small mb-0">Download sales, commission, & auction spreadsheets.</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-auto pt-2 border-top border-light-subtle">
                                <span class="text-muted small">Format: <strong>.xlsx</strong></span>
                                <a href="admin_export.php" class="btn btn-gold btn-sm"><i class="fa fa-file-excel me-1"></i> Export Excel</a>
                            </div>
                        </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        $(document).ready(function(){
            $('button[data-bs-toggle="tab"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('id'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#' + activeTab).tab('show');
            }

            // Chart.js implementation
            const salesData = <?php echo json_encode($sales_data); ?>;
            const catData = <?php echo json_encode($category_dist); ?>;
            const aucData = <?php echo json_encode($auction_activity); ?>;

            // 1. Sales & Commission Chart
            const ctxSales = document.getElementById('salesChart');
            if (ctxSales) {
                new Chart(ctxSales, {
                    type: 'line',
                    data: {
                        labels: salesData.map(d => d.month),
                        datasets: [
                            {
                                label: 'Total Sales (Rp)',
                                data: salesData.map(d => d.total_sales),
                                borderColor: '#ab8e5b',
                                backgroundColor: 'rgba(171, 142, 91, 0.1)',
                                fill: true,
                                tension: 0.3
                            },
                            {
                                label: 'Hiranya Commission (Rp)',
                                data: salesData.map(d => d.total_commission),
                                borderColor: '#1c2431',
                                backgroundColor: 'rgba(28, 36, 49, 0.1)',
                                fill: true,
                                tension: 0.3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // 2. Category Distribution Chart
            const ctxCat = document.getElementById('categoryChart');
            if (ctxCat) {
                new Chart(ctxCat, {
                    type: 'doughnut',
                    data: {
                        labels: catData.map(d => d.name),
                        datasets: [{
                            data: catData.map(d => d.artwork_count),
                            backgroundColor: [
                                '#1c2431', '#ab8e5b', '#475569', '#64748B', '#94A3B8', '#CBD5E1'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }

            // 3. Auction Bid Activity Chart
            const ctxAuc = document.getElementById('auctionChart');
            if (ctxAuc) {
                new Chart(ctxAuc, {
                    type: 'bar',
                    data: {
                        labels: aucData.map(d => d.title),
                        datasets: [{
                            label: 'Number of Bids Placed',
                            data: aucData.map(d => d.bid_count),
                            backgroundColor: '#ab8e5b',
                            borderColor: '#ab8e5b',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }

            $(document).on('click', '.btn-delete-swal', function(e) {
                e.preventDefault();
                var href = $(this).attr('href');
                var text = $(this).data('confirm-text') || 'Are you sure you want to delete this data?';
                Swal.fire({
                    title: 'Are you sure?',
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ab8e5b',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
            
            $(document).on('click', '.btn-confirm-submit-swal', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var text = $(this).data('confirm-text') || 'Apakah Anda yakin?';
                Swal.fire({
                    title: 'Are you sure?',
                    text: text,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ab8e5b',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
