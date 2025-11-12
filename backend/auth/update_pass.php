<?php

include("../../resource/conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $new_password = $_POST['new_password'] ?? null;

    if (!$user_id || !$new_password) {
        die("Missing user_id or new_password");
    }

    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$row = mysqli_fetch_assoc($result)) {
        die("User not found");
    }

    if (!empty($row['password'])) {
        die("Password already set");
    }


    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

    
    $updateSql = "UPDATE users SET password = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "si", $hashedPassword, $user_id);
    mysqli_stmt_execute($updateStmt);

    if (mysqli_stmt_affected_rows($updateStmt) > 0) {
        echo "Password set successfully";
    } else {
        echo "Failed to update password";
    }
}
