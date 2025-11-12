<?php
session_start();
include("../../resource/conn.php");




header("Content-Type: application/json");

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roll_no       = trim($_POST['roll_no'] ?? '');
    $name          = trim($_POST['name'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $department_id = intval($_POST['department_id'] ?? 0);
    $year          = intval($_POST['year'] ?? 0);
    $role_id       = 1;

    if (empty($roll_no) || empty($name) || empty($email) || $department_id === 0 || $year === 0) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE roll_no = ? OR email = ?");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("ss", $roll_no, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Roll Number or Email already exists."]);
        $stmt->close();
        exit;
    }
    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO users (roll_no, name, email, department_id, year, role_id) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit;
    }
    $stmt->bind_param("sssiii", $roll_no, $name, $email, $department_id, $year, $role_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Student added successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add student. Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
