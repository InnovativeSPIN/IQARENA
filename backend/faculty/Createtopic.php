<?php



if (!isset($_SESSION['id']) && !isset($_SESSION['is_admin'])) {
    die("Unauthorized access");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST['topicName'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '' || $description === '') {
        die("Title and description are required");
    }

   
        $by_admin = 0;
        $added_by = $_SESSION['id'];


    $stmt = $conn->prepare("INSERT INTO topics (title, description, added_by, by_admin, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->bind_param("ssii", $title, $description, $added_by, $by_admin);

    if ($stmt->execute()) {
        header("Location: ./topic.php");
        exit;
    } else {
        die("Error: " . $stmt->error);
    }
}
?>
