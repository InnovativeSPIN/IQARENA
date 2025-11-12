<?php
// backend/faculty/toggle_test_status.php
include("../../resource/conn.php");
include("../../resource/session.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../faculty/recent-test.php');
    exit;
}

$test_id = $_POST['test_id'] ?? null;
$new_status = isset($_POST['new_status']) ? (int)$_POST['new_status'] : null;

if (!$test_id || !in_array($new_status, [0,1])) {
    header('Location: ../../faculty/recent-test.php');
    exit;
}

$stmt = $conn->prepare("UPDATE tests SET is_active=? WHERE test_id=? AND added_by=?");
$stmt->bind_param("iii", $new_status, $test_id, $_SESSION['id']);
$stmt->execute();
$stmt->close();
$conn->close();

header('Location: ../../faculty/recent-test.php');
exit;
?>
