<?php
include("../resource/conn.php");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

if (!isset($_SESSION['role_id'])) {
    header("Location: ../login.php");
    exit;
}

// $year = $_SESSION['year'];  
// $department_id = $_SESSION['department_id'];
$year = 1;  
$department_id = 1;
// fetch tests along with topic & sub_topic names

$today = date('Y-m-d');
$stmt = $conn->prepare("
    SELECT 
        t.test_id, 
        t.title, 
        t.description, 
        t.subject, 
        t.added_by, 
        t.num_questions, 
        t.department_id, 
        t.year, 
        t.date, 
        t.time_slot, 
        t.duration_minutes, 
        t.created_at, 
        t.is_active,
        tp.title AS topic_name,
        st.title AS sub_topic_name
    FROM tests t
    LEFT JOIN topics tp ON t.topic_id = tp.topic_id
    LEFT JOIN sub_topics st ON t.sub_topic_id = st.sub_topic_id
    WHERE t.year = ? AND t.department_id = ? AND t.is_active = 1 
    ORDER BY t.created_at DESC
");

$stmt->bind_param("ii", $year, $department_id);
$stmt->execute();
$result = $stmt->get_result();


$student_id = $_SESSION['id'];
$tests = [];
while ($row = $result->fetch_assoc()) {
    // Check if student has completed this test
    $checkStmt = $conn->prepare("SELECT status FROM student_tests WHERE student_id = ? AND test_id = ? LIMIT 1");
    $checkStmt->bind_param("ii", $student_id, $row['test_id']);
    $checkStmt->execute();
    $checkRes = $checkStmt->get_result();
    $row['completed'] = false;
    if ($checkRes && $checkRes->num_rows > 0) {
        $stRow = $checkRes->fetch_assoc();
        if ($stRow['status'] === 'completed') {
            $row['completed'] = true;
        }
    }
    $checkStmt->close();
    $tests[] = $row;
}
$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Quiz | IQ Arena</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/student/dash.css">
    <link rel="stylesheet" href="../assets/css/resource/style.css">

</head>

<body>

    <?php include('./header.php'); ?>

    <main class="container">

        <nav>
            <a href="index.php">Dashboard</a>
            <a href="test-list.php" class="active">Daily Quiz</a>
            <a href="leaderboard.php">Leaderboard</a>
            <a href="Result.php">Result</a>
            <a href="reports.php">Reports</a>
        </nav>
<div id="quiz-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
    <?php if (count($tests) > 0): ?>
        <?php foreach ($tests as $test): ?>
            <div class="quiz-card relative bg-white rounded-3xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col justify-between border-l-8 border-orange-400">

                <!-- Test Live Status Blinking Badge -->
                <span class="absolute top-4 right-4 flex items-center gap-2">
                    <?php if($test['is_active'] == 1): ?>
                        <span class="blinking-dot bg-green-500 rounded-full w-3 h-3 mr-1 animate-pulse"></span>
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-300">Test Live</span>
                    <?php else: ?>
                        <span class="blinking-dot bg-gray-400 rounded-full w-3 h-3 mr-1 animate-pulse"></span>
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-600 border border-gray-300">Not Live</span>
                    <?php endif; ?>
                </span>

                <!-- Card Header / Title -->
                <div class="mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 mb-1"><?php echo htmlspecialchars($test['title']); ?></h3>
                    <p class="text-gray-500 text-sm"><?php echo htmlspecialchars($test['description']); ?></p>
                </div>

                <!-- Info Section -->
                <div class="bg-orange-50 text-xl text-gray-600 space-y-1 mb-6 bg-gray-50 p-4  rounded-xl">
                    <p><span class="font-semibold text-gray-700">Subject:</span> <?php echo htmlspecialchars($test['subject']); ?></p>
                    <p><span class="font-semibold text-gray-700">Topic:</span> <?php echo htmlspecialchars($test['topic_name'] ?? 'N/A'); ?></p>
                    <p><span class="font-semibold text-gray-700">Sub Topic:</span> <?php echo htmlspecialchars($test['sub_topic_name'] ?? 'N/A'); ?></p>
                    <p><span class="font-semibold text-gray-700">Date:</span> <?php echo htmlspecialchars($test['date']); ?></p>
                    <p><span class="font-semibold text-gray-700">Time Slot:</span> <?php echo htmlspecialchars($test['time_slot']); ?></p>
                    <p><span class="font-semibold text-gray-700">Duration:</span> <?php echo htmlspecialchars($test['duration_minutes']); ?> mins</p>
                </div>

                <!-- Action Button -->
                <?php if($test['is_active'] == 1 && !$test['completed']): ?>
                    <a href="./test.php?id=<?php echo $test['test_id']; ?>"
                       class="mt-auto inline-block text-center bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 text-white font-semibold px-5 py-3 rounded-2xl shadow-lg transition-all duration-300">
                        Start Test
                    </a>
                <?php elseif($test['completed']): ?>
                    <button disabled
                        class="mt-auto inline-block text-center bg-gray-300 text-gray-600 font-semibold px-5 py-3 rounded-2xl shadow-lg cursor-not-allowed">
                        Already Attempted
                    </button>
                <?php else: ?>
                    <button disabled
                        class="mt-auto inline-block text-center bg-gray-300 text-gray-600 font-semibold px-5 py-3 rounded-2xl shadow-lg cursor-not-allowed">
                        Inactive
                    </button>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="col-span-3 text-gray-500 text-lg">No tests available for your year and department.</p>
    <?php endif; ?>
</div>





    </main>

    <?php include('../resource/footer.php'); ?>

</body>

</html>