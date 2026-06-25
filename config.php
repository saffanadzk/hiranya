<?php
$conn = mysqli_connect("localhost", "root", "", "hiranya");
if (!$conn) { die("Connection Defeat: " . mysqli_connect_error()); }
session_start();
?>