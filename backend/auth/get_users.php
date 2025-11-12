<?php

include("../../resource/conn.php");

if (isset($_POST['roll_no'])) {
    $roll_no = mysqli_real_escape_string($conn, $_POST['roll_no']);

    $sql = "SELECT u.id, u.name, u.email, u.year, d.full_name AS department 
            FROM users u 
            JOIN departments d ON u.department_id = d.id 
            WHERE u.roll_no = '$roll_no' LIMIT 1";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "User not found"]);
    }
}
