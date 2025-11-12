<?php
include("../resource/conn.php");
include("../resource/session.php");

// Get topic, subtopic, and uploaded question IDs from GET
$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$sub_topic_id = isset($_GET['sub_topic_id']) ? intval($_GET['sub_topic_id']) : 0;
$uploaded_ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];

// Fetch topic and subtopic names
$topic = $subtopic = null;
if ($topic_id) {
    $stmt = $conn->prepare("SELECT title FROM topics WHERE topic_id = ?");
    $stmt->bind_param("i", $topic_id);
    $stmt->execute();
    $topic = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
if ($sub_topic_id) {
    $stmt = $conn->prepare("SELECT title FROM sub_topics WHERE sub_topic_id = ?");
    $stmt->bind_param("i", $sub_topic_id);
    $stmt->execute();
    $subtopic = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Fetch uploaded questions
$questions = [];
if ($uploaded_ids && $sub_topic_id) {
    $in = implode(',', array_map('intval', $uploaded_ids));
    $sql = "SELECT question_text, option_a, option_b, option_c, option_d, correct_option, mark FROM questions WHERE sub_topic_id = $sub_topic_id AND question_id IN ($in)";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploaded Questions</title>
    <link rel="stylesheet" href="../assets/css/resource/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <!-- Header -->
    <?php include('./header.php'); ?>
    <main class="container mx-auto p-6 flex flex-col gap-6">
        <main class="container mx-auto px-4 py-6">
            <?php include('./nav.php'); ?>
            <section id="page-title" class="mb-6">
                <h2 class="text-2xl font-bold text-green-600 text-center uppercase">Questions Uploaded Successfully!</h2>
            </section>
            <div class="mb-6 text-center">
                <span class="font-semibold">Topic:</span> <?= htmlspecialchars($topic['title'] ?? '') ?><br>
                <span class="font-semibold">Subtopic:</span> <?= htmlspecialchars($subtopic['title'] ?? '') ?>
            </div>
            <h3 class="text-xl font-bold mb-2 text-center">Uploaded Questions</h3>
            <div class="overflow-x-auto">
            <?php if ($questions): ?>
                <table class="min-w-full border border-gray-300 rounded-xl overflow-hidden">
                    <thead class="bg-orange-100">
                        <tr>
                            <th class="px-4 py-2">Question</th>
                            <th class="px-4 py-2">A</th>
                            <th class="px-4 py-2">B</th>
                            <th class="px-4 py-2">C</th>
                            <th class="px-4 py-2">D</th>
                            <th class="px-4 py-2">Correct</th>
                            <th class="px-4 py-2">Mark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($questions as $q): ?>
                        <tr class="border-t">
                            <td class="px-4 py-2">
                                <?php
                                $text = $q['question_text'];
                                $lines = explode("\n", $text);
                                if (count($lines) > 1) {
                                    echo '<pre class="bg-gray-100 rounded p-2 text-sm overflow-x-auto"><code>' . htmlspecialchars($text) . '</code></pre>';
                                } else {
                                    echo nl2br(htmlspecialchars($text));
                                }
                                ?>
                            </td>
                            <td class="px-4 py-2"><?= htmlspecialchars($q['option_a']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($q['option_b']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($q['option_c']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($q['option_d']) ?></td>
                            <td class="px-4 py-2 font-bold text-green-600"><?= htmlspecialchars($q['correct_option']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($q['mark']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-gray-500">No questions found.</div>
            <?php endif; ?>
            </div>
        </main>
    </main>
    <?php include('../resource/footer.php'); ?>
</body>
</html>
