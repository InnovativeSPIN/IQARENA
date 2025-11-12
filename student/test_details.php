<?php
require_once '../resource/conn.php';
require_once '../resource/session.php';

$student_id = $_GET['student_id'] ?? null;
$test_date = $_GET['test_date'] ?? null;
if (!$student_id || !$test_date) {
    echo '<div class="error">Invalid test or student.</div>';
    exit;
}

$student_sql = "SELECT u.id, u.name, d.full_name AS department, u.year FROM users u LEFT JOIN departments d ON u.department_id = d.id WHERE u.id = '" . mysqli_real_escape_string($conn, $student_id) . "' LIMIT 1";
$student_result = mysqli_query($conn, $student_sql);
if ($student_result === false) {
    echo '<div class="error">SQL Error (Student Query): ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
    exit;
}
$student = mysqli_fetch_assoc($student_result);
if (!$student) {
    echo '<div class="error">Student not found.</div>';
    exit;
}

// Fetch test info
$test_sql = "SELECT st.student_test_id, t.title, t.subject, t.topic_id, st.score, st.end_time FROM student_tests st JOIN tests t ON st.test_id = t.test_id WHERE st.student_id = '" . mysqli_real_escape_string($conn, $student_id) . "' AND st.end_time = '" . mysqli_real_escape_string($conn, $test_date) . "' LIMIT 1";
$test_result = mysqli_query($conn, $test_sql);
if ($test_result === false) {
    echo '<div class="error">SQL Error (Test Query): ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
    exit;
}
$test = mysqli_fetch_assoc($test_result);

// Fetch topic name if available
$topic_name = '';
if ($test && $test['topic_id']) {
    $topic_sql = "SELECT topic_name FROM topics WHERE topic_id = '" . mysqli_real_escape_string($conn, $test['topic_id']) . "' LIMIT 1";
    $topic_result = mysqli_query($conn, $topic_sql);
    if ($topic_result !== false) {
        $topic_row = mysqli_fetch_assoc($topic_result);
        $topic_name = $topic_row['topic_name'] ?? '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Details</title>
    <style>
        :root {
            --color-primary: #F97316;
            --color-primary-hover: #EA580C;
            --color-secondary: #FF8C00;
            --color-accent: #FFA500;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #FFFFFF;
            padding: 2rem;
            line-height: 1.6;
        }

        .nav-bar {
            display: flex;
            align-items: center;
            background-color: #f8f8f8;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .back {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            background-color: var(--color-primary);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .back:hover {
            background-color: var(--color-primary-hover);
        }

        h2 {
            color: var(--color-primary);
            margin-bottom: 1.5rem;
            text-align: center;
            font-size: 2rem;
        }

        .error {
            background-color: #ffe6e6;
            color: #d32f2f;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            text-align: center;
        }

        .info {
            background-color: #f8f8f8;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .info p {
            margin: 0.5rem 0;
            font-size: 1rem;
        }

        .info strong {
            color: #333;
            font-weight: 600;
        }
table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 8px;
    overflow: hidden;
    margin-top: 1rem;
}

th, td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #eee;
}

th {
    background-color: var(--color-secondary);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.95rem;
}

td {
    color: #333;
    font-size: 1rem;
}

tr:nth-child(even) {
    background-color: #f8f8f8;
}

tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.2s ease;
}

table tr:last-child th,
table tr:last-child td {
    border-bottom: none; 
}

/* Responsive table */
@media (max-width: 600px) {
    table {
        display: block;
        overflow-x: auto; 
        white-space: nowrap; 
    }

    th, td {
        padding: 0.8rem;
        font-size: 0.9rem;
        min-width: 120px; 
    }

    th {
        font-size: 0.85rem;
    }

    td {
        font-size: 0.85rem;
    }
}
        @media (max-width: 600px) {
            body {
                padding: 1rem;
            }

            .nav-bar {
                padding: 0.8rem;
            }

            .back {
                width: 100%;
                text-align: center;
            }

            .info {
                padding: 1rem;
            }

            th, td {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="nav-bar">
        <a href="report.php" class="back">&larr; Back to My Report</a>
    </div>
    <h2>Test Details</h2>
    <div class="info">
        <p><strong>Name:</strong> <?= htmlspecialchars($student['name'] ?? 'N/A') ?></p>
        <p><strong>Department:</strong> <?= htmlspecialchars($student['department'] ?? 'N/A') ?></p>
        <p><strong>Year:</strong> <?= htmlspecialchars($student['year'] ?? 'N/A') ?></p>
        <p><strong>ID:</strong> <?= htmlspecialchars($student['id'] ?? 'N/A') ?></p>
    </div>
    <?php if ($test): ?>
    <table>
        <tr><th>Test Title</th><td><?= htmlspecialchars($test['title']) ?></td></tr>
        <tr><th>Subject</th><td><?= htmlspecialchars($test['subject']) ?></td></tr>
        <tr><th>Score</th><td><?= htmlspecialchars($test['score']) ?></td></tr>
        <tr><th>Date</th><td><?= htmlspecialchars($test['end_time']) ?></td></tr>
        <tr><th>Topic</th><td><?= htmlspecialchars($topic_name ?: 'N/A') ?></td></tr>
    </table>
    <?php else: ?>
    <div class="error">Test details not found.</div>
    <?php endif; ?>
</body>
</html>