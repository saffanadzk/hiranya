<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'artist') { 
    header("Location: login.php"); exit; 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Submit Artwork</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="submit-page">

    <div class="submit-card">

        <div class="submit-card-header">
            <div class="logo">H</div>
            <h2>Submit Artwork</h2>
            <p>Share your work with our collectors</p>
        </div>

        <div class="submit-card-body">
            <form action="process_submit.php" method="POST" enctype="multipart/form-data">

                <div class="field-group">
                    <label for="title">Artwork Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g. Sunset Over Java" required>
                </div>

                <div class="field-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Tell the story behind your artwork..."></textarea>
                </div>

                <div class="field-group">
                    <label for="price">Price (IDR)</label>
                    <div style="position:relative;">
                        <span style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#8b8378; font-size:14px;">Rp</span>
                        <input type="number" id="price" name="price" step="1" min="0"
                            placeholder="e.g. 1500000"
                            style="padding-left: 36px;">
                    </div>
                </div>

                <div class="field-group">
                    <label>Artwork Image</label>
                    <div class="file-upload-wrapper">
                        <label class="file-upload-label" for="artwork_image">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Click to upload image (JPG, PNG, WEBP)</span>
                        </label>
                        <input type="file" id="artwork_image" name="artwork_image"
                               accept="image/*" required
                               onchange="document.getElementById('file-name').textContent = this.files[0]?.name || ''">
                        <div id="file-name"></div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Submit Artwork</button>
            </form>

            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
        </div>

    </div>

</body>
</html>