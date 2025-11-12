<?php
include("../../resource/conn.php");
session_start();

if (!isset($_GET['topic_id'])) {
    echo json_encode([]);
    exit;
}
$topic_id = intval($_GET['topic_id']);
$user_id = $_SESSION['id'] ?? 0;

$stmt = $conn->prepare("SELECT sub_topic_id, title FROM sub_topics WHERE topic_id = ? AND (by_admin = 1 OR added_by = ?) ORDER BY created_at DESC");
$stmt->bind_param("ii", $topic_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$sub_topics = [];
while ($row = $result->fetch_assoc()) {
    $sub_topics[] = $row;
}
header('Content-Type: application/json');
echo json_encode($sub_topics);
