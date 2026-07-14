<?php
session_start();
require_once 'config.php';
$message = '';
$message_type = '';

if (isset($_POST['submit_change'])) {
    $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    $new_password = $_POST['new_password'];
    
    if (!empty($new_username) && !empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        $query = "UPDATE users SET username = ?, password = ? WHERE role = 'admin' OR role_id = 3 LIMIT 1";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $new_username, $hashed_password);
        
        if (mysqli_stmt_execute($stmt)) {
            $message = "Username & Password Admin is updated!<br>Username baru: <b>$new_username</b><br><br><b>PENTING: Delete file immediately 'change_admin.php' ini dari folder htdocs/hiranya demi keamanan!</b>";
            $message_type = "success";
        } else {
            $message = "Failed to update database: " . mysqli_error($conn);
            $message_type = "danger";
        }
    } else {
        $message = "Form cannot be empty!";
        $message_type = "warning";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Admin Account - Hiranya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1C2431; color: white; font-family: sans-serif; }
        .card-change { background: white; color: #333; border-radius: 12px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.3); margin-top: 100px; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-change">
                <h3 class="text-center mb-4">Change Admin Credentials</h3>
                
                <?php if (!empty($message)): ?>
                    <div class="alert alert-<?= $message_type; ?>">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">New Admin Username</label>
                        <input type="text" name="new_username" class="form-control" placeholder="Enter new username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Admin Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
                    </div>
                    <button type="submit" name="submit_change" class="btn btn-primary w-100">Save Admin Changes</button>
                </form>
                <div class="text-center mt-3">
                    <a href="login.php" class="text-muted text-decoration-none">&larr; Back to Login Page</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
