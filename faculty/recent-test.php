<?php
// faculty/recent-tests.php
include("../resource/conn.php");
include("../resource/session.php");

// Fetch tests created by this faculty
// Use correct column names and faculty id column
$stmt = $conn->prepare("SELECT test_id, title, is_active, created_at FROM tests WHERE added_by = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$tests = [];
while ($row = $result->fetch_assoc()) {
    $tests[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recent Tests</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/resource/style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Recent Tests</h2>
        <div class="bg-white rounded-2xl shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($tests as $test): ?>
                    <div class="border rounded-xl p-5 flex flex-col gap-3 shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-center">
                            <h3 class="font-bold text-lg text-orange-700 truncate" title="<?= htmlspecialchars($test['title']) ?>">
                                <?= htmlspecialchars($test['title']) ?>
                            </h3>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $test['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' ?>">
                                <?= $test['is_active'] ? 'Active' : 'Inactive' ?>
                            </span>
                        </div>
                        <div class="text-xs text-gray-500">Created: <?= htmlspecialchars($test['created_at']) ?></div>
                        <div class="flex justify-end">
                            <form method="post" action="../backend/faculty/toggle_test_status.php" class="inline">
                                <input type="hidden" name="test_id" value="<?= $test['test_id'] ?>">
                                <input type="hidden" name="new_status" value="<?= $test['is_active'] ? 0 : 1 ?>">
                                <button type="submit" class="px-3 py-1 rounded bg-orange-500 text-white text-xs font-semibold hover:bg-orange-600 transition">
                                    <?= $test['is_active'] ? 'Deactivate' : 'Activate' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($tests)): ?>
                    <div class="col-span-full py-8 text-center text-gray-500">No tests found.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include('../resource/footer.php'); ?>
</body>
</html>
