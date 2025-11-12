<?php

include("../../resource/conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['roll_no'])) {
    $roll_no = trim($_POST['roll_no']);

 
    $stmt = $conn->prepare("
        SELECT r.role_name
        FROM users u
        JOIN roles r ON u.role_id = r.role_id
        WHERE u.roll_no = ?
    ");

    if ($stmt) {
        $stmt->bind_param("s", $roll_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            echo $user['role_name']; 
        } else {
            echo "User not found";
        }

        $stmt->close();
    } else {
        echo "Query error: " . $conn->error;
    }
}
?>
