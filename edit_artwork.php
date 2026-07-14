<?php
session_start();
include 'config.php';

$id = $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM artworks WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    header("Location: my_artworks.php");
    exit;
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $desc  = $_POST['description'];
    $price = $_POST['price'];

    $upd = mysqli_prepare($conn, "UPDATE artworks SET title=?, description=?, price=? WHERE id=?");
    mysqli_stmt_bind_param($upd, "ssdi", $title, $desc, $price, $id);
    if (mysqli_stmt_execute($upd)) {
        $_SESSION['message'] = "Artwork updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update artwork!";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: my_artworks.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artwork</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="submit-page">
<div class="submit-page-wrapper">
    <div class="submit-card">

        <div class="submit-card-header">
            <h2>Edit Artwork</h2>
            <p>Update your artwork details</p>
        </div>

        <div class="submit-card-body">
            <form method="POST">

                <div class="field-group">
                    <label for="title">Artwork Title</label>
                    <input type="text" id="title" name="title"
                           value="<?php echo htmlspecialchars($data['title']); ?>" required>
                </div>

                <div class="field-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"><?php echo htmlspecialchars($data['description']); ?></textarea>
                </div>

                <div class="field-group">
                    <label for="price">Price (IDR)</label>
                    <div class="price-wrapper">
                        <span class="price-prefix">Rp</span>
                        <input type="number" id="price" name="price" step="1" min="0"
                               value="<?php echo $data['price']; ?>">
                    </div>
                </div>

                <button type="submit" name="update" class="btn-submit">Update Artwork</button>
            </form>

            <a href="my_artworks.php" class="back-link">← Back to My Artworks</a>
        </div>

    </div>
</div>
</body>
</html>