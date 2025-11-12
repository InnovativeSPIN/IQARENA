<?php
include '../resource/conn.php'; // Database connection

// Fetch all departments

$dept_query = "SELECT id, full_name FROM departments";
$dept_result = mysqli_query($conn, $dept_query);
$departments = [];
if ($dept_result === false) {
    echo '<div style="color:red;">Error fetching departments. Please check the database table and connection.</div>';
    exit;
}
while ($row = mysqli_fetch_assoc($dept_result)) {
    $departments[] = $row;
}

// For each department, fetch top 2 faculty by their highest student test score
$leaderboard = [];
foreach ($departments as $dept) {
    $faculty_query = "SELECT f.name, d.name AS department, MAX(st.score) AS score FROM faculty f JOIN departments d ON f.department_id = d.id JOIN student_tests st ON st.faculty_id = f.id WHERE d.id = {$dept['id']} AND st.status = 'completed' GROUP BY f.id ORDER BY score DESC LIMIT 2";
    $faculty_result = mysqli_query($conn, $faculty_query);
    $faculty_list = [];
    while ($row = mysqli_fetch_assoc($faculty_result)) {
        $faculty_list[] = $row;
    }
    $leaderboard[$dept['name']] = $faculty_list;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Leaderboard by Department</title>
    <style>
        body {
            background: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(255, 152, 0, 0.15);
        }
        h2 {
            color: #FF9800;
            text-align: center;
            margin-bottom: 2rem;
        }
        .department {
            margin-bottom: 2rem;
        }
        .department h3 {
            color: #F57C00;
            margin-bottom: 1rem;
        }
        .faculty-list {
            display: flex;
            gap: 2rem;
            justify-content: flex-start;
        }
        .faculty-card {
            background: #FFD54F;
            border: 2px solid #FFA726;
            border-radius: 12px;
            padding: 1rem 2rem;
            min-width: 200px;
            text-align: center;
            color: #F57C00;
            box-shadow: 0 2px 8px rgba(255, 152, 0, 0.10);
        }
        .faculty-card .score {
            font-size: 1.5rem;
            font-weight: bold;
            color: #FF9800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Faculty Leaderboard by Department</h2>
        <?php foreach ($leaderboard as $dept_name => $faculty_list): ?>
            <div class="department">
                <h3><?php echo htmlspecialchars($dept_name); ?></h3>
                <div class="faculty-list">
                    <?php if (!empty($faculty_list)): ?>
                        <?php foreach ($faculty_list as $faculty): ?>
                            <div class="faculty-card">
                                <div class="name">Faculty: <?php echo htmlspecialchars($faculty['name']); ?></div>
                                <div class="score">Top Score: <?php echo $faculty['score']; ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>No faculty data available.</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
