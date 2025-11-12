<?php
include("../resource/conn.php");
session_start();

if (!isset($_SESSION['role_id'])) { 
     header("Location: ../login.php"); 
     exit;
}

$student_id = $_SESSION['id'];
$test_id = $_GET['id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO student_tests (student_id, test_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $student_id, $test_id);

    if ($stmt->execute()) {
        $student_test_id = $conn->insert_id;
        $_SESSION['student_test_id'] = $student_test_id;
        header("Location: quiz.php?id=$test_id");
        exit;
    } else {
        echo "Error: " . $stmt->error;
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Start Test</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

<div class="bg-white p-8 rounded-xl shadow-md text-center">
    <h1 class="text-2xl font-bold mb-4">Welcome to the Quiz</h1>
    <p class="mb-6">Click below to start your test.</p>
    <form method="POST">
        <button type="submit" class="bg-orange-600 text-white py-2 px-6 rounded-md">Start Test</button>
    </form>
</div>

</body>
</html>
