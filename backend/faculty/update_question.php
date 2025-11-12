<?php
// backend/faculty/update_question.php
include("../../resource/conn.php");
include("../../resource/session.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

// Validate input
$question_id = $_POST['question_id'] ?? null;
$question_text = $_POST['question_text'] ?? '';
$option_a = $_POST['option_a'] ?? '';
$option_b = $_POST['option_b'] ?? '';
$option_c = $_POST['option_c'] ?? '';
$option_d = $_POST['option_d'] ?? '';
$correct_option = $_POST['correct_option'] ?? '';

if (!$question_id || !$question_text || !$option_a || !$option_b || !$option_c || !$option_d || !$correct_option) {
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$stmt = $conn->prepare("UPDATE questions SET question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_option=? WHERE question_id=?");
$stmt->bind_param("ssssssi", $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $question_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database update failed']);
}
$stmt->close();
$conn->close();
?>
