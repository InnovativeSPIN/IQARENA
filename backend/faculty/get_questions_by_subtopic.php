<?php
include("../../resource/conn.php");
session_start();

if (!isset($_GET['sub_topic_id'])) {
    echo json_encode([]);
    exit;
}
$sub_topic_id = intval($_GET['sub_topic_id']);

$stmt = $conn->prepare("SELECT question_id, question_text, option_a, option_b, option_c, option_d, correct_option FROM questions WHERE sub_topic_id = ? ORDER BY question_id ASC");
$stmt->bind_param("i", $sub_topic_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}
header('Content-Type: application/json');
echo json_encode($questions);
