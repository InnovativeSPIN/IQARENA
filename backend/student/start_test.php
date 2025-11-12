<?php


$student_id = $_SESSION['id'];
$test_id = $_GET['id'];

// Insert new test attempt
$stmt = $conn->prepare("INSERT INTO student_tests (student_id, test_id) VALUES (?, ?)");
$stmt->execute([$student_id, $test_id]);

$student_test_id = $conn->lastInsertId();

// Fetch questions for this test
$questions = $conn->query("SELECT * FROM questions WHERE 1")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'student_test_id' => $student_test_id,
    'questions' => $questions
]);
