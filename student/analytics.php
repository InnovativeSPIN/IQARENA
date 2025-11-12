<?php
include '../resource/conn.php';
include '../resource/session.php';

include 'header.php';

// Get logged-in student id and department
$student_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : 0;
$department_id = isset($_SESSION['department_id']) ? intval($_SESSION['department_id']) : 0;

// Fetch department name
$dept_name = '';
if ($department_id) {
    $dept_query = mysqli_query($conn, "SELECT full_name FROM departments WHERE id = $department_id");
    if ($dept_query && mysqli_num_rows($dept_query) > 0) {
        $dept_row = mysqli_fetch_assoc($dept_query);
        $dept_name = $dept_row['full_name'];
    }
}

// Fetch analytics for the logged-in student only
$sql = "SELECT AVG(st.score) AS avg_score,
       SUM((SELECT COUNT(*) FROM student_answers sa WHERE sa.student_test_id = st.student_test_id)) AS total_attempted,
       SUM((SELECT COUNT(*) FROM student_answers sa WHERE sa.student_test_id = st.student_test_id AND sa.is_correct = 1)) AS total_correct,
       SUM((SELECT COUNT(*) FROM student_answers sa WHERE sa.student_test_id = st.student_test_id AND sa.is_correct = 0)) AS total_wrong,
       COUNT(st.student_test_id) AS tests_taken
FROM student_tests st
WHERE st.student_id = $student_id";
$result = mysqli_query($conn, $sql);

$avg_score = 0;
$total_attempted = 0;
$total_correct = 0;
$total_wrong = 0;
$tests_taken = 0;
$percentage = 0;

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $avg_score = round($row['avg_score'], 2);
    $total_attempted = $row['total_attempted'];
    $total_correct = $row['total_correct'];
    $total_wrong = $row['total_wrong'];
    $tests_taken = $row['tests_taken'];
    $percentage = ($total_attempted > 0) ? round(($total_correct / $total_attempted) * 100, 2) : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Analytics</title>

  <script src="https://cdn.tailwindcss.com"></script>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --color-primary: #F97316; /* Vibrant orange */
            --color-primary-hover: #EA580C; /* Darker orange */
            --color-secondary: #FBBF24; /* Light orange-yellow */
            --color-accent: #FED7AA; /* Very light orange */
            --color-background: #FFF7ED; /* Pale orange background */
            --color-text: #431407; /* Dark brown for text */
            --color-border: #FECACA; /* Light orange border */
        }
        body {
            background: linear-gradient(135deg, var(--color-background) 0%, #FFE4E1 100%); /* Orange gradient */
            color: var(--color-text);
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            padding: 3rem;
            min-height: 100vh;
            margin: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 2.5rem;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--color-primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(249, 115, 22, 0.2); /* Orange shadow */
        }
        .table-container {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(249, 115, 22, 0.1); /* Orange shadow */
            max-width: 900px;
            margin: 0 auto 3rem auto;
            border: 1px solid var(--color-border);
            transition: transform 0.3s ease;
        }
        .table-container:hover {
            transform: translateY(-5px);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 12px;
            overflow: hidden;
            background: #FFFFFF;
        }
        th, td {
            padding: 1.25rem;
            text-align: center;
            border-bottom: 1px solid var(--color-border);
            font-size: 1rem;
        }
        th {
            background: var(--color-secondary);
            color: #FFFFFF;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }
        td {
            background: #FFFBF5; /* Very light orange background */
            color: var(--color-text);
        }
        tr {
            transition: background 0.3s ease;
        }
        tr:hover {
            background: #FFF1E6; /* Light orange hover */
        }
        #charts {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .chart-container {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.08); /* Orange shadow */
            border: 1px solid var(--color-border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.12); /* Orange shadow */
        }
        canvas {
            border-radius: 8px;
        }
        @media (max-width: 768px) {
            body {
                padding: 1.5rem;
            }
            .table-container {
                padding: 1.25rem;
                max-width: 100%;
            }
            th, td {
                padding: 0.75rem;
                font-size: 0.85rem;
            }
            h1 {
                font-size: 1.75rem;
            }
            #charts {
                grid-template-columns: 1fr;
            }
            .chart-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <h1>My Analytics</h1>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Avg. Score</th>
                    <th>Total Attempted</th>
                    <th>Total Correct</th>
                    <th>Total Wrong</th>
                    <th>Percentage</th>
                    <th>Tests Taken</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($dept_name); ?></td>
                    <td><?php echo $avg_score; ?></td>
                    <td><?php echo $total_attempted; ?></td>
                    <td><?php echo $total_correct; ?></td>
                    <td><?php echo $total_wrong; ?></td>
                    <td><?php echo $percentage; ?>%</td>
                    <td><?php echo $tests_taken; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="charts">
        <div class="chart-container">
            <canvas id="barChart" width="400" height="200"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="lineChart" width="400" height="200"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="pieChart" width="400" height="200"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="radarChart" width="400" height="300"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Bar Chart
        new Chart(document.getElementById('barChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Average Score'],
                datasets: [{
                    label: 'Score',
                    data: [<?php echo $avg_score; ?>],
                    backgroundColor: 'var(--color-primary)',
                    borderColor: 'var(--color-primary-hover)',
                    borderWidth: 2
                }]
            },
            options: {
                animation: { duration: 1200, easing: 'easeOutBounce' },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(249, 115, 22, 0.1)' } }, /* Orange grid */
                    x: { grid: { display: false } }
                },
                plugins: { legend: { labels: { color: 'var(--color-text)' } } }
            }
        });
        // Line Chart
        new Chart(document.getElementById('lineChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Accuracy'],
                datasets: [{
                    label: 'Percentage',
                    data: [<?php echo $percentage; ?>],
                    borderColor: 'var(--color-secondary)',
                    backgroundColor: 'rgba(251, 191, 36, 0.2)', /* Light orange fill */
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3
                }]
            },
            options: {
                animation: { duration: 1000, easing: 'easeInOutQuart' },
                scales: {
                    y: { beginAtZero: true, max: 100, grid: { color: 'rgba(249, 115, 22, 0.1)' } }, /* Orange grid */
                    x: { grid: { display: false } }
                },
                plugins: { legend: { labels: { color: 'var(--color-text)' } } }
            }
        });
        // Pie Chart
        new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Correct', 'Wrong'],
                datasets: [{
                    data: [<?php echo $total_correct; ?>, <?php echo $total_wrong; ?>],
                    backgroundColor: ['var(--color-primary)', 'var(--color-accent)'],
                    borderColor: ['var(--color-primary-hover)', 'var(--color-accent)'],
                    borderWidth: 2
                }]
            },
            options: {
                animation: { duration: 800, easing: 'easeInOutQuad' },
                plugins: {
                    legend: { position: 'right', labels: { color: 'var(--color-text)' } }
                }
            }
        });
        // Radar Chart
        new Chart(document.getElementById('radarChart').getContext('2d'), {
            type: 'radar',
            data: {
                labels: ['Score', 'Correct', 'Wrong', 'Attempted', 'Percentage'],
                datasets: [{
                    label: 'My Analytics',
                    data: [<?php echo $avg_score; ?>, <?php echo $total_correct; ?>, <?php echo $total_wrong; ?>, <?php echo $total_attempted; ?>, <?php echo $percentage; ?>],
                    backgroundColor: 'rgba(249, 115, 22, 0.2)', /* Light orange fill */
                    borderColor: 'var(--color-primary)',
                    pointBackgroundColor: 'var(--color-primary-hover)',
                    borderWidth: 2
                }]
            },
            options: {
                animation: { duration: 1200, easing: 'easeOutBounce' },
                scales: {
                    r: {
                        angleLines: { display: true, color: 'rgba(249, 115, 22, 0.2)' }, /* Orange angle lines */
                        grid: { color: 'rgba(249, 115, 22, 0.2)' }, /* Orange grid */
                        suggestedMin: 0,
                        suggestedMax: Math.max(<?php echo $avg_score; ?>, <?php echo $total_attempted; ?>, <?php echo $percentage; ?>, 100)
                    }
                },
                plugins: {
                    legend: { position: 'top', labels: { color: 'var(--color-text)' } }
                }
            }
        });
    </script>
</body>
</html>