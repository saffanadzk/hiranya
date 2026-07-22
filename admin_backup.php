<?php
session_start();
require_once 'config.php';

// Authenticate Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied.");
}

// Prevent memory limits & timeout issues for large backups
ini_set('memory_limit', '512M');
set_time_limit(300);

// Get all tables
$tables = [];
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sql_dump = "-- Hiranya Database Backup\n";
$sql_dump .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
$sql_dump .= "-- Host: localhost\n";
$sql_dump .= "-- Database: hiranya\n";
$sql_dump .= "--------------------------------------------------------\n\n";

// Disable foreign key checks during import to avoid errors
$sql_dump .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

foreach ($tables as $table) {
    $sql_dump .= "-- ------------------------------------------------------\n";
    $sql_dump .= "-- Table structure for table `$table`\n";
    $sql_dump .= "-- ------------------------------------------------------\n\n";
    
    // Get table schema
    $create_res = mysqli_query($conn, "SHOW CREATE TABLE `$table`");
    $create_row = mysqli_fetch_row($create_res);
    $sql_dump .= "DROP TABLE IF EXISTS `$table`;\n";
    $sql_dump .= $create_row[1] . ";\n\n";
    
    // Get table records
    $data_res = mysqli_query($conn, "SELECT * FROM `$table`");
    $num_fields = mysqli_num_fields($data_res);
    
    if (mysqli_num_rows($data_res) > 0) {
        $sql_dump .= "-- Dumping data for table `$table`\n";
        $sql_dump .= "INSERT INTO `$table` VALUES\n";
        
        $rows = [];
        while ($row = mysqli_fetch_row($data_res)) {
            $values = [];
            for ($i = 0; $i < $num_fields; $i++) {
                if (is_null($row[$i])) {
                    $values[] = "NULL";
                } else {
                    $escaped = mysqli_real_escape_string($conn, $row[$i]);
                    // Escape carriage returns and line feeds
                    $escaped = str_replace(["\r\n", "\n", "\r"], "\\n", $escaped);
                    $values[] = "'" . $escaped . "'";
                }
            }
            $rows[] = "(" . implode(", ", $values) . ")";
        }
        $sql_dump .= implode(",\n", $rows) . ";\n\n";
    }
}

// Re-enable foreign key checks
$sql_dump .= "SET FOREIGN_KEY_CHECKS=1;\n";

// Send download headers
$filename = "hiranya_backup_" . date('Y-m-d_H-i-s') . ".sql";
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

echo $sql_dump;
exit();
?>
