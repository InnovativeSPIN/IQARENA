<?php
// Database connection for IQARENA
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'iqarena';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}
?>
