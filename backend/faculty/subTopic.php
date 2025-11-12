<?php
include("../../resource/conn.php");
include("../../resource/session.php");

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user ID from session
    $user_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;

    // Sanitize input
    $topic_id    = isset($_POST['parentTopic']) ? intval($_POST['parentTopic']) : 0;
    $title       = isset($_POST['subTopicName']) ? trim($_POST['subTopicName']) : '';
    $description = isset($_POST['subTopicDescription']) ? trim($_POST['subTopicDescription']) : '';
    $by_admin    = 0;

    // Validate required fields
    if ($topic_id > 0 && $title !== '') {
        $stmt = $conn->prepare("
            INSERT INTO sub_topics 
            (topic_id, title, description, added_by, by_admin, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW(), NOW())
        ");

        if (!$stmt) {
            die("<p>SQL Prepare failed: " . $conn->error . "</p>");
        }

        $stmt->bind_param("issii", $topic_id, $title, $description, $user_id, $by_admin);

        if ($stmt->execute()) {
            // Redirect back to topic page
            header("Location: ../../faculty/topic.php");
            exit();
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>⚠ Topic ID and Title are required.</p>";
        // Debugging: show what was actually posted
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
}
?>
