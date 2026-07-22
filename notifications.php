<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'delete') {
        $notif_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($notif_id > 0) {
            mysqli_query($conn, "DELETE FROM notifications WHERE id = $notif_id AND user_id = $user_id");
            $_SESSION['message'] = "Notification successfully deleted.";
            $_SESSION['message_type'] = "success";
        }
    } elseif ($action === 'clear_all') {
        mysqli_query($conn, "DELETE FROM notifications WHERE user_id = $user_id");
        $_SESSION['message'] = "All notification have been cleared.";
        $_SESSION['message_type'] = "success";
    }
    header("Location: notifications.php");
    exit();
}

$notif_query = mysqli_query($conn, "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY id DESC");
$notifications = [];
while ($row = mysqli_fetch_assoc($notif_query)) {
    $notifications[] = $row;
}
?>
<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <title>Notification - Hiranya</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Playfair+Display:wght@500&family=Work+Sans&family=Cinzel:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light <?= isset($theme_class) ? $theme_class : ''; ?>">

    <?php include 'partials/navbar.php'; ?>

    <div class="container py-5" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="font-family: 'Playfair Display', serif; font-weight:700; color: #1c2431; margin-bottom: 5px;">Platform Notification</h2>
                <p class="text-muted small mb-0">Manage all notifications and important information from Hiranya.</p>
            </div>
            <?php if (!empty($notifications)): ?>
                <a href="notifications.php?action=clear_all" class="btn btn-sm btn-clear-all font-monospace px-3 py-2" onclick="return confirm('Clear all notifications?')">CLEAR ALL</a>
            <?php endif; ?>
        </div>

        <div class="notif-card shadow-sm">
            <?php if (empty($notifications)): ?>
                <div class="text-center py-5">
                    <i class="fa fa-bell-slash fa-3x text-muted mb-3" style="opacity: 0.5;"></i>
                    <h5 class="text-secondary" style="font-family: 'Playfair Display', serif;">No notifications available</h5>
                    <p class="text-muted small mb-0">All new notifications will appear here.</p>
                </div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($notifications as $notif): ?>
                        <div class="notif-item d-flex justify-content-between align-items-start gap-3">
                            <div class="d-flex gap-3">
                                <div class="text-warning mt-1">
                                    <i class="fa fa-bell fa-lg"></i>
                                </div>
                                <div>
                                    <p class="mb-1 text-dark" style="font-size: 14px; line-height: 1.5;"><?= htmlspecialchars($notif['message']); ?></p>
                                    <small class="text-muted font-monospace" style="font-size: 10px;"><?= date('d M Y, H:i', strtotime($notif['created_at'])); ?></small>
                                </div>
                            </div>
                            <a href="notifications.php?action=delete&id=<?= $notif['id']; ?>" class="delete-btn" title="Delete Notification">
                                <i class="fa fa-times-circle"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-4">
            <a href="profile.php" class="text-decoration-none small text-muted font-monospace"><i class="fa fa-arrow-left me-1"></i> BACK TO ACCOUNT</a>
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
