<?php 
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'config.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM artworks WHERE id = '$id'");
$data = mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bidding - <?php echo $data['judul_karya']; ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row">
        <div class="col-lg-6">
            <img src="assets/img/artworks/<?php echo $data['image_url']; ?>" class="img-fluid" alt="Artwork">
        </div>
        <div class="col-lg-6">
            <h1><?php echo $data['judul_karya']; ?></h1>
            <p><?php echo $data['deskripsi']; ?></p>
            
            <?php if(isset($_SESSION['user_id'])) : ?>
                <form action="process_bid.php" method="POST">
                    <input type="hidden" name="artwork_id" value="<?php echo $id; ?>">
                    <div class="mb-3">
                        <label>Enter your bid (Bid):</label>
                        <input type="number" name="bid_amount" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Place Bid</button>
                </form>
            <?php else : ?>
                <div class="alert alert-warning">
                    if you must <a href="login.php">Login</a> to place a bid (bid).
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>