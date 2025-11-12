<?php
include '../resource/conn.php';
include '../resource/session.php';
include './header.php';

// Get selected year from GET param
$selected_year = isset($_GET['year']) ? intval($_GET['year']) : 0;

$where = '';
if (isset($_SESSION['department_id'])) {
	$dept_id = intval($_SESSION['department_id']);
	$where = "WHERE u.department_id = $dept_id";
	if ($selected_year > 0) {
		$where .= " AND u.year = $selected_year";
	}
}

$sql = "SELECT u.id AS student_id, u.name AS student_name, d.full_name AS department,
	   AVG(st.score) AS avg_score,
	   SUM((SELECT COUNT(*) FROM student_answers sa WHERE sa.student_test_id = st.student_test_id)) AS total_attempted,
	   SUM((SELECT COUNT(*) FROM student_answers sa WHERE sa.student_test_id = st.student_test_id AND sa.is_correct = 1)) AS total_correct,
	   SUM((SELECT COUNT(*) FROM student_answers sa WHERE sa.student_test_id = st.student_test_id AND sa.is_correct = 0)) AS total_wrong,
	   COUNT(st.student_test_id) AS tests_taken
FROM student_tests st
JOIN users u ON st.student_id = u.id
JOIN departments d ON u.department_id = d.id
$where
GROUP BY u.id, u.name, d.full_name";
$result = mysqli_query($conn, $sql);

$chart_labels = [];
$chart_scores = [];
$chart_percentages = [];
$chart_correct = [];
$chart_wrong = [];
$chart_departments = [];
$rows = [];

if ($result && mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		$chart_labels[] = $row['student_name'];
		$chart_departments[] = $row['department'];
		$chart_scores[] = round($row['avg_score'], 2);
		$percentage = ($row['total_attempted'] > 0) ? round(($row['total_correct'] / $row['total_attempted']) * 100, 2) : 0;
		$chart_percentages[] = $percentage;
		$chart_correct[] = $row['total_correct'];
		$chart_wrong[] = $row['total_wrong'];
		$rows[] = array_merge($row, ['percentage' => $percentage]);
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Advanced Analytics Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	<style>
		:root {
			--color-primary: #F97316;
			--color-primary-hover: #EA580C;
			--color-secondary: #FFA500;
			--color-accent: #FFD580;
			--color-background: #FFF7ED;
			--color-text: #222;
			--color-border: #FFE0B2;
		}
		body {
			background: var(--color-background);
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
			text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
		}
		.table-container {
			background: #FFF;
			border-radius: 16px;
			padding: 2rem;
			box-shadow: 0 4px 16px rgba(249,115,22,0.08);
			max-width: 1200px;
			margin: 0 auto;
			border: 1px solid var(--color-border);
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
			background: var(--color-primary);
			color: #FFF;
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 1.2px;
		}
		td {
			background: #FFF7ED;
			color: var(--color-text);
		}
		tr {
			transition: background 0.3s ease;
		}
		tr:hover {
			background: #FFE0B2;
		}
		.view-details-btn {
			background: var(--color-primary);
			color: #FFF;
			border: none;
			padding: 0.5rem 1rem;
			border-radius: 6px;
			cursor: pointer;
			font-size: 0.9rem;
			font-weight: 500;
			transition: background 0.2s ease, transform 0.2s ease;
		}
		.view-details-btn:hover {
			background: var(--color-primary-hover);
			transform: scale(1.05);
		}
		#detailsModal {
			display: none;
			position: fixed;
			top: 0;
			left: 0;
			width: 100vw;
			height: 100vh;
			background: rgba(0, 0, 0, 0.3);
			z-index: 999;
			align-items: center;
			justify-content: center;
		}
		.modal-content {
			background: #FFF;
			padding: 2rem;
			border-radius: 16px;
			max-width: 1000px;
			width: 90vw;
			max-height: 90vh;
			overflow: auto;
			box-shadow: 0 4px 16px rgba(249,115,22,0.08);
			position: relative;
			display: flex;
			flex-direction: column;
			align-items: center;
			border: 1px solid var(--color-border);
		}
		.close-btn {
			position: absolute;
			top: 1rem;
			right: 1rem;
			background: none;
			border: none;
			color: var(--color-primary);
			font-size: 1.5rem;
			cursor: pointer;
			transition: color 0.2s ease;
		}
		.close-btn:hover {
			color: var(--color-primary-hover);
		}
		#modalTitle {
			color: var(--color-primary);
			margin-bottom: 1.5rem;
			font-size: 1.8rem;
			font-weight: 600;
			text-align: center;
		}
		#modalCharts {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
			gap: 2rem;
			width: 100%;
		}
		#modalCharts p {
			color: var(--color-text);
			font-size: 1.1rem;
			margin-bottom: 1rem;
			text-align: center;
		}
		.chart-container {
			background: #FFF7ED;
			border-radius: 16px;
			padding: 1.5rem;
			box-shadow: 0 2px 8px rgba(249,115,22,0.08);
			border: 1px solid var(--color-border);
		}
		#downloadReportBtn {
			background: var(--color-primary);
			color: #FFF;
			border: none;
			padding: 0.75rem 1.5rem;
			border-radius: 6px;
			cursor: pointer;
			font-size: 1rem;
			font-weight: 500;
			margin: 1.5rem auto 0;
			transition: background 0.2s ease, transform 0.2s ease;
		}
		#downloadReportBtn:hover {
			background: var(--color-primary-hover);
			transform: scale(1.05);
		}
		canvas {
			border-radius: 8px;
		}
		#progressBarContainer {
			width: 100%;
			background: #FFE0B2;
			border-radius: 8px;
			height: 24px;
			overflow: hidden;
			margin: 0 auto;
			max-width: 500px;
		}
		#progressBar {
			height: 100%;
			width: 0;
			background: var(--color-primary);
			transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
		}
		#progressValue {
			font-weight: 600;
			display: block;
			text-align: right;
			margin-top: 4px;
			color: var(--color-primary);
		}
		select {
			padding: 8px 16px;
			border-radius: 6px;
			border: 1px solid var(--color-primary);
			background: #FFF7ED;
			color: var(--color-primary);
			font-size: 1rem;
			cursor: pointer;
			transition: border-color 0.2s ease;
		}
		select:focus {
			outline: none;
			border-color: var(--color-primary-hover);
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
			.modal-content {
				width: 95%;
				padding: 1.25rem;
			}
			#modalCharts {
				grid-template-columns: 1fr;
			}
			.chart-container {
				padding: 1rem;
			}
			select {
				width: 100%;
				margin-top: 0.5rem;
			}
		}
        
	</style>
</head>
<body>
	<h1>Analytics Dashboard</h1>
	<form method="get" style="max-width: 400px; margin: 0 auto 2rem auto;">
		<label for="year" style="font-weight: 600; margin-right: 10px;">Filter by Year:</label>
		<select name="year" id="year" onchange="this.form.submit()">
			<option value="0" <?php if($selected_year==0) echo 'selected'; ?>>All Years</option>
			<option value="1" <?php if($selected_year==1) echo 'selected'; ?>>1st Year</option>
			<option value="2" <?php if($selected_year==2) echo 'selected'; ?>>2nd Year</option>
			<option value="3" <?php if($selected_year==3) echo 'selected'; ?>>3rd Year</option>
			<option value="4" <?php if($selected_year==4) echo 'selected'; ?>>4th Year</option>
		</select>
	</form>
	<div class="table-container">
		<table>
			<thead>
				<tr>
					<th>Student Name</th>
					<th>Department</th>
					<th>Avg. Score</th>
					<th>Total Attempted</th>
					<th>Total Correct</th>
					<th>Total Wrong</th>
					<th>Percentage</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php if (!empty($rows)) {
					foreach($rows as $row) {
						echo "<tr>
							<td>" . htmlspecialchars($row['student_name']) . "</td>
							<td>" . htmlspecialchars($row['department']) . "</td>
							<td>" . round($row['avg_score'], 2) . "</td>
							<td>" . $row['total_attempted'] . "</td>
							<td>" . $row['total_correct'] . "</td>
							<td>" . $row['total_wrong'] . "</td>
							<td>" . $row['percentage'] . "%</td>
							<td><button class='view-details-btn' data-student='" . htmlspecialchars($row['student_name']) . "'>View Details</button></td>
						</tr>";
					}
				} else {
					echo "<tr><td colspan='8'>No analytics data found.</td></tr>";
				} ?>
			</tbody>
		</table>
	</div>

	<div id="detailsModal">
		<div class="modal-content">
			<button class="close-btn" onclick="document.getElementById('detailsModal').style.display='none'">&times;</button>
			<h2 id="modalTitle"></h2>
			<div id="modalCharts"></div>
			<button id="downloadReportBtn">Download Report</button>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		let currentStudent = null;
		let currentDept = null;
		let currentScore = null;
		let currentPercent = null;
		let currentCorrect = null;
		let currentWrong = null;

		document.querySelectorAll('.view-details-btn').forEach(btn => {
			btn.addEventListener('click', function() {
				const student = this.getAttribute('data-student');
				const idx = <?php echo json_encode($chart_labels); ?>.indexOf(student);
				const dept = <?php echo json_encode($chart_departments); ?>[idx];
				const score = <?php echo json_encode($chart_scores); ?>[idx];
				const percent = <?php echo json_encode($chart_percentages); ?>[idx];
				const correct = <?php echo json_encode($chart_correct); ?>[idx];
				const wrong = <?php echo json_encode($chart_wrong); ?>[idx];
                
				currentStudent = student;
				currentDept = dept;
				currentScore = score;
				currentPercent = percent;
				currentCorrect = correct;
				currentWrong = wrong;

				document.getElementById('modalTitle').innerText = `${student}'s Analytics`;
				document.getElementById('modalCharts').innerHTML = `
					<p><b>Department:</b> ${dept}</p>
					<div style='margin-bottom:20px;'>
						<label style='font-weight:600;'>Percentage:</label>
						<div id='progressBarContainer'>
							<div id='progressBar'></div>
						</div>
						<span id='progressValue'></span>
					</div>
					<div class='chart-container'>
						<canvas id='modalBar' width='400' height='200'></canvas>
					</div>
					<div class='chart-container'>
						<canvas id='modalLine' width='400' height='200'></canvas>
					</div>
					<div class='chart-container'>
						<canvas id='modalPie' width='400' height='200'></canvas>
					</div>
					<div class='chart-container'>
						<canvas id='modalRadar' width='400' height='300'></canvas>
					</div>
				`;
				// Animated progress bar for percentage
				setTimeout(function() {
					var bar = document.getElementById('progressBar');
					var value = document.getElementById('progressValue');
					bar.style.width = percent + '%';
					value.textContent = percent + '%';
				}, 100);
				// Radar Chart
				const ctxRadar = document.getElementById('modalRadar').getContext('2d');
				new Chart(ctxRadar, {
					type: 'radar',
					data: {
						labels: ['Score', 'Correct', 'Wrong', 'Attempted', 'Percentage'],
						datasets: [{
							label: student + ' Analytics',
							data: [score, correct, wrong, correct+wrong, percent],
							backgroundColor: 'rgba(249,115,22,0.2)',
							borderColor: 'var(--color-primary)',
							pointBackgroundColor: 'var(--color-primary-hover)',
							borderWidth: 2
						}]
					},
					options: {
						animation: {duration: 1200, easing: 'easeOutBounce'},
						scales: {
							r: {
								angleLines: {display: true, color: 'rgba(161, 87, 87, 0.1)'},
								grid: {color: 'rgba(136, 78, 78, 0.1)'},
								suggestedMin: 0,
								suggestedMax: Math.max(score, correct+wrong, percent, 100)
							}
						},
						plugins: {
							legend: {position: 'top', labels: {color: 'var(--color-text)'}}
						}
					}
				});
				// Bar Chart
				const ctxBar = document.getElementById('modalBar').getContext('2d');
				new Chart(ctxBar, {
					type: 'bar',
					data: {
						labels: ['Average Score'],
						datasets: [{
							label: 'Score',
							data: [score],
							backgroundColor: 'var(--color-primary)',
							borderColor: 'var(--color-primary-hover)',
							borderWidth: 2
						}]
					},
					options: {
						animation: { duration: 1200, easing: 'easeOutBounce' },
						scales: {
							y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.05)' } },
							x: { grid: { display: false } }
						},
						plugins: { legend: { labels: { color: 'var(--color-text)' } } }
					}
				});
				// Line Chart
				const ctxLine = document.getElementById('modalLine').getContext('2d');
				new Chart(ctxLine, {
					type: 'line',
					data: {
						labels: ['Accuracy'],
						datasets: [{
							label: 'Percentage',
							data: [percent],
							borderColor: 'var(--color-secondary)',
							backgroundColor: 'rgba(16, 185, 129, 0.2)',
							fill: true,
							tension: 0.4,
							borderWidth: 3
						}]
					},
					options: {
						animation: { duration: 1000, easing: 'easeInOutQuart' },
						scales: {
							y: { beginAtZero: true, max: 100, grid: { color: 'rgba(0, 0, 0, 0.05)' } },
							x: { grid: { display: false } }
						},
						plugins: { legend: { labels: { color: 'var(--color-text)' } } }
					}
				});
				// Pie Chart
				const ctxPie = document.getElementById('modalPie').getContext('2d');
				new Chart(ctxPie, {
					type: 'pie',
					data: {
						labels: ['Correct', 'Wrong'],
						datasets: [{
							data: [correct, wrong],
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
				document.getElementById('detailsModal').style.display = 'flex';
			});
		});

		// Download report as PDF
		document.getElementById('downloadReportBtn').addEventListener('click', function() {
			const script = document.createElement('script');
			script.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
			script.onload = function() {
				const { jsPDF } = window.jspdf;
				const doc = new jsPDF({
					orientation: 'portrait',
					unit: 'mm',
					format: 'a4'
				});

				// Add title and metadata
				doc.setFontSize(18);
				doc.setTextColor(249, 115, 22); // --color-primary
				doc.text(`${currentStudent}'s Analytics Report`, 20, 20);
				doc.setFontSize(12);
				doc.setTextColor(31, 41, 55); // --color-text
				doc.text(`Department: ${currentDept}`, 20, 30);
				doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 20, 38);

				// Add charts
				const barCanvas = document.getElementById('modalBar');
				const lineCanvas = document.getElementById('modalLine');
				const pieCanvas = document.getElementById('modalPie');

				const barImg = barCanvas.toDataURL('image/png');
				const lineImg = lineCanvas.toDataURL('image/png');
				const pieImg = pieCanvas.toDataURL('image/png');

				doc.setFontSize(14);
				doc.setTextColor(31, 41, 55); // --color-text
				doc.text('Average Score', 20, 50);
				doc.addImage(barImg, 'PNG', 20, 55, 80, 40);
				doc.text('Accuracy Percentage', 20, 105);
				doc.addImage(lineImg, 'PNG', 20, 110, 80, 40);
				doc.text('Correct vs Wrong Answers', 20, 160);
				doc.addImage(pieImg, 'PNG', 20, 165, 80, 40);

				// Add summary data
				doc.setFontSize(12);
				doc.setTextColor(31, 41, 55); // --color-text
				doc.text(`Average Score: ${currentScore.toFixed(2)}`, 20, 215);
				doc.text(`Accuracy: ${currentPercent.toFixed(2)}%`, 20, 223);
				doc.text(`Correct Answers: ${currentCorrect}`, 20, 231);
				doc.text(`Wrong Answers: ${currentWrong}`, 20, 239);

				// Add footer
				doc.setFontSize(10);
				doc.setTextColor(107, 114, 128);
				doc.text('Generated by Analytics Dashboard', 20, 280);

				doc.save(`${currentStudent}_analytics_report.pdf`);
			};
			document.body.appendChild(script);
		});
	</script>
</body>
</html>