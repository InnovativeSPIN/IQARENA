<?php
include("../../resource/conn.php");
session_start();

if (!isset($_GET['topic_id'])) {
    echo json_encode([]);
    exit;
}
$topic_id = intval($_GET['topic_id']);
$user_id = $_SESSION['id'] ?? 0;

// Get subtopics and their question count
$stmt = $conn->prepare("SELECT s.sub_topic_id, s.title, COUNT(q.question_id) as question_count FROM sub_topics s LEFT JOIN questions q ON s.sub_topic_id = q.sub_topic_id WHERE s.topic_id = ? AND (s.by_admin = 1 OR s.added_by = ?) GROUP BY s.sub_topic_id ORDER BY s.created_at DESC");
$stmt->bind_param("ii", $topic_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$sub_topics = [];
while ($row = $result->fetch_assoc()) {
    $sub_topics[] = $row;
}
header('Content-Type: application/json');
echo json_encode($sub_topics);
