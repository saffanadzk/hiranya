<?php
session_start();
require_once 'config.php';

// Authenticate Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}

// Check if file was uploaded
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['sql_file'])) {
    header("Location: admin_dashboard.php?restore_error=" . urlencode("No file uploaded."));
    exit();
}

$file = $_FILES['sql_file'];

// Check upload error
if ($file['error'] !== UPLOAD_ERR_OK) {
    header("Location: admin_dashboard.php?restore_error=" . urlencode("File upload error code: " . $file['error']));
    exit();
}

// Validate file extension
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if ($ext !== 'sql') {
    header("Location: admin_dashboard.php?restore_error=" . urlencode("Only .sql files are allowed for database import."));
    exit();
}

// Set limits for large imports
ini_set('memory_limit', '512M');
set_time_limit(300);

// Read SQL content
$sql_content = file_get_contents($file['tmp_name']);

if (empty(trim($sql_content))) {
    header("Location: admin_dashboard.php?restore_error=" . urlencode("Uploaded SQL file is empty."));
    exit();
}

// Wrap with Foreign Key Check toggles
$full_sql = "SET FOREIGN_KEY_CHECKS=0;\n" . $sql_content . "\nSET FOREIGN_KEY_CHECKS=1;\n";

// Execute multi query
if (mysqli_multi_query($conn, $full_sql)) {
    $success_count = 0;
    do {
        // Store first result set if any
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
        $success_count++;
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));

    if (mysqli_errno($conn)) {
        $error_msg = mysqli_error($conn);
        header("Location: admin_dashboard.php?restore_error=" . urlencode("Error during import: " . $error_msg));
        exit();
    }

    header("Location: admin_dashboard.php?restore_success=1");
    exit();
} else {
    $error_msg = mysqli_error($conn);
    header("Location: admin_dashboard.php?restore_error=" . urlencode("Database restoration failed: " . $error_msg));
    exit();
}
?>
