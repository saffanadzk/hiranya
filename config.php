<?php
$conn = mysqli_connect("localhost", "root", "", "hiranya");
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
?>