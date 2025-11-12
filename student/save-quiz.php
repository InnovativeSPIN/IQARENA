<?php
include("../resource/conn.php");
session_start();

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

$student_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $test_id = intval($data['test_id'] ?? 0);
    $score = intval($data['score'] ?? 0);
    $answers = $data['answers'] ?? [];

    // 1. Ensure student_tests row exists
    $stmt = $conn->prepare("SELECT student_test_id FROM student_tests WHERE student_id = ? AND test_id = ?");
    $stmt->bind_param("ii", $student_id, $test_id);
    $stmt->execute();
    $stmt->bind_result($student_test_id);
    if (!$stmt->fetch()) {
        $stmt->close();
        // insert new row
        $stmt = $conn->prepare("INSERT INTO student_tests (student_id, test_id, start_time, status) VALUES (?, ?, NOW(), 'started')");
        $stmt->bind_param("ii", $student_id, $test_id);
        $stmt->execute();
        $student_test_id = $stmt->insert_id;
        $stmt->close();
    } else {
        $stmt->close();
    }

    // 2. Save each answer
    foreach ($answers as $qid => $ans) {
        // Determine correctness
        $stmt = $conn->prepare("SELECT correct_option FROM questions WHERE question_id = ?");
        $stmt->bind_param("i", $qid);
        $stmt->execute();
        $stmt->bind_result($correct_option);
        $stmt->fetch();
        $stmt->close();

        $is_correct = ($ans === $correct_option) ? 1 : 0;

        $stmt = $conn->prepare("
            INSERT INTO student_answers (student_test_id, question_id, answer, is_correct, marked_at)
            VALUES (?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE answer = VALUES(answer), is_correct = VALUES(is_correct), marked_at = NOW()
        ");
        $stmt->bind_param("iisi", $student_test_id, $qid, $ans, $is_correct);
        $stmt->execute();
        $stmt->close();
    }

    // 3. Update total score, end time, and status
    $stmt = $conn->prepare("
        UPDATE student_tests
        SET score = ?, end_time = NOW(), status = 'completed'
        WHERE student_test_id = ?
    ");
    $stmt->bind_param("ii", $score, $student_test_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(["success" => true, "student_test_id" => $student_test_id]);
    exit;
}
?>
