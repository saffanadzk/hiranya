<?php include 'config.php';
if (isset($_POST['submit'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    mysqli_query($conn, "INSERT INTO artworks (judul_karya, deskripsi) VALUES ('$judul', '$deskripsi')");
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="container">
        <h2>Tambah Karya</h2>
        <form method="POST">
            <input type="text" name="judul" placeholder="Judul Karya" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi">
            <button type="submit" name="submit">Save</button>
        </form>
    </div>
</body>
</html>