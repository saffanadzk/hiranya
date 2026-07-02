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
                $_SESSION['message'] = "Kategori '$name' berhasil ditambahkan!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal menambahkan kategori: " . mysqli_error($conn);
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Nama kategori tidak boleh kosong!";
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
                $_SESSION['message'] = "Kategori berhasil diperbarui!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal memperbarui kategori: " . mysqli_error($conn);
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Input tidak valid!";
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
                $_SESSION['message'] = "Kategori karya seni berhasil diperbarui!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal memperbarui kategori karya seni: " . mysqli_error($conn);
                $_SESSION['message_type'] = "danger";
            }
        }
    }

    elseif ($action === 'assign_auction') {
        $artwork_id = (int)$_POST['artwork_id'];
        $start_bid = (double)$_POST['start_bid'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        if ($artwork_id > 0 && $start_bid >= 0 && !empty($start_time) && !empty($end_time)) {
            mysqli_begin_transaction($conn);

            try {
                $del_query = "DELETE FROM auctions WHERE artwork_id = ?";
                $del_stmt = mysqli_prepare($conn, $del_query);
                mysqli_stmt_bind_param($del_stmt, "i", $artwork_id);
                mysqli_stmt_execute($del_stmt);

                $ins_query = "INSERT INTO auctions (artwork_id, start_bid, current_bid, start_time, end_time, status) VALUES (?, ?, ?, ?, ?, 'active')";
                $ins_stmt = mysqli_prepare($conn, $ins_query);
                mysqli_stmt_bind_param($ins_stmt, "iddss", $artwork_id, $start_bid, $start_bid, $start_time, $end_time);
                mysqli_stmt_execute($ins_stmt);

                $upd_query = "UPDATE artworks SET status = 'in_auction' WHERE id = ?";
                $upd_stmt = mysqli_prepare($conn, $upd_query);
                mysqli_stmt_bind_param($upd_stmt, "i", $artwork_id);
                mysqli_stmt_execute($upd_stmt);

                mysqli_commit($conn);
                $_SESSION['message'] = "Karya seni berhasil dimasukkan ke lelang!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Gagal memasukkan ke lelang: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Data lelang tidak lengkap atau tidak valid!";
            $_SESSION['message_type'] = "warning";
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
                $_SESSION['message'] = "Kategori berhasil dihapus!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Gagal menghapus kategori: " . $e->getMessage();
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
                $_SESSION['message'] = "Karya seni berhasil dihapus dari daftar lelang!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Gagal menghapus dari lelang: " . $e->getMessage();
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

                $_SESSION['message'] = "Karya seni berhasil dihapus!";
                $_SESSION['message_type'] = "success";
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $_SESSION['message'] = "Gagal menghapus karya seni: " . $e->getMessage();
                $_SESSION['message_type'] = "danger";
            }
        }
    }
}

header("Location: admin_dashboard.php");
exit;
?>
