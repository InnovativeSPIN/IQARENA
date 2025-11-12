<?php 

include(__DIR__ . "/conn.php");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();


if (!isset($_SESSION['role_id'])) { 
     header("Location: ../login.php");     
}
?>
