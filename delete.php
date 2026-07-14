<?php 
include 'config.php';
$id = (int)$_GET['id'];
if ($id > 0) {
    if (mysqli_query($conn, "DELETE FROM artworks WHERE id=$id")) {
        $_SESSION['message'] = "Karya seni berhasil dihapus!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menghapus karya seni!";
        $_SESSION['message_type'] = "danger";
    }
}
header("Location: my_artworks.php");
exit;
?>