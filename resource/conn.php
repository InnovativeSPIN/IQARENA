<?php

// $host = "localhost";
// $user = "root";
// $pass = "";
// $db   = "iqarena";


$host = "localhost";
$user = "nscet_iqarena";
$pass = "nscet_iqarena";
$db   = "nscet_iqarena";


$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully"; 
?>
