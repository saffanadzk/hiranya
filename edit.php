<?php include 'config.php';
$id = $_GET['id'];
$data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM artworks WHERE id=$id"));

if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE artworks SET judul_karya='{$_POST['judul']}', deskripsi='{$_POST['deskripsi']}' WHERE id=$id");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <h2>Edit Karya</h2>
        <form method="POST">
            <input type="text" name="judul" value="<?php echo $data['judul_karya']; ?>">
            <input type="text" name="deskripsi" value="<?php echo $data['deskripsi']; ?>">
            <button type="submit" name="update">Update</button>
        </form>
    </div>
</body>
</html>