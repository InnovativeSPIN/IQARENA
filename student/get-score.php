<?php
include("../resource/conn.php");
session_start();

$student_test_id = intval($_GET['student_test_id'] ?? 0);
if (!$student_test_id) {
    echo json_encode(["score" => 0]);
    exit;
}
$stmt = $conn->prepare("SELECT score FROM student_tests WHERE student_test_id = ?");
$stmt->bind_param("i", $student_test_id);
$stmt->execute();
$stmt->bind_result($score);
$stmt->fetch();
$stmt->close();
echo json_encode(["score" => $score ?? 0]);
exit;
