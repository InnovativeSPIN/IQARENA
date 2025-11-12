<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../resource/conn.php';
require_once '../resource/session.php';

$student_id = $_GET['student_id'] ?? null;
if (!$student_id) {
    echo '<div class="error">No student selected.</div>';
    exit;
}

// Fetch student info including roll number
$student_sql = "SELECT u.id, u.roll_no, u.name, d.full_name AS department, u.year 
                FROM users u 
                LEFT JOIN departments d ON u.department_id = d.id 
                WHERE u.id = '" . mysqli_real_escape_string($conn, $student_id) . "' 
                LIMIT 1";
$student_result = mysqli_query($conn, $student_sql);
$student = mysqli_fetch_assoc($student_result);

// Fetch all tests attended by the student
$tests_sql = "SELECT st.student_test_id, t.title, t.subject, t.topic_id, st.score, st.end_time 
              FROM student_tests st 
              JOIN tests t ON st.test_id = t.test_id 
              WHERE st.student_id = '" . mysqli_real_escape_string($conn, $student_id) . "' 
              ORDER BY st.end_time DESC";
$tests_result = mysqli_query($conn, $tests_sql);
$tests = [];
while ($row = mysqli_fetch_assoc($tests_result)) {
    $tests[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Detailed Report</title>
    <style>
        body { background: #fff; padding: 2rem; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        h2 { color: #F97316; margin-bottom: 1rem; }
        .info { margin-bottom: 2rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.08); border-radius: 8px; }
        th, td { padding: 1rem; text-align: left; }
        th { background: #FF8C00; color: #fff; }
        tr:nth-child(even) { background: #f8f8f8; }
        tr:hover { background: #f1f1f1; }
        td { border-bottom: 1px solid #eee; }
        .back { display: inline-block; margin-bottom: 1rem; color: #F97316; text-decoration: none; font-weight: bold; }
        .btn-details { background: #F97316; color: #fff; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; }
        .btn-details:hover { background: #FF8C00; }
    </style>
</head>
<body>
    <a href="report.php" class="back">&larr; Back to Report</a>
    <button id="downloadPdfBtn" class="btn-details" style="margin-bottom:1rem;">Download PDF</button>
    
    <div id="pdfMeta" style="display:none;">
        <span id="pdfName">Name: <?= htmlspecialchars($student['name'] ?? '') ?></span>
        <span id="pdfDept">Department: <?= htmlspecialchars($student['department'] ?? '') ?></span>
        <span id="pdfYear">Year: <?= htmlspecialchars($student['year'] ?? '') ?></span>
        <span id="pdfRoll">Roll No: <?= htmlspecialchars($student['roll_no'] ?? '') ?></span>
    </div>

    <!-- Hidden logos for PDF -->
    <img id="collegeLogo" src="https://i.imgur.com/0QZQwQw.png" alt="College Logo" style="display:none;" />
    <img id="iqarenaLogo" src="https://i.imgur.com/2QZQwQw.png" alt="IQARENA Logo" style="display:none;" />

    <h2>Student Details</h2>
    <div class="info">
        <strong>Name:</strong> <?= htmlspecialchars($student['name'] ?? '') ?><br>
        <strong>Department:</strong> <?= htmlspecialchars($student['department'] ?? '') ?><br>
        <strong>Year:</strong> <?= htmlspecialchars($student['year'] ?? '') ?><br>
        <strong>Roll No:</strong> <?= htmlspecialchars($student['roll_no'] ?? '') ?>
    </div>

    <h2>Tests Attended</h2>
    <table id="studentTestTable">
        <tr>
            <th>S.No</th>
            <th>Test Title</th>
            <th>Subject</th>
            <th>Score</th>
            <th>Date</th>
            <th>Topic ID</th>
        </tr>
        <?php 
        $i = 1;
        foreach ($tests as $test): 
        ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($test['title']) ?></td>
            <td><?= htmlspecialchars($test['subject']) ?></td>
            <td><?= htmlspecialchars($test['score']) ?></td>
            <td><?= htmlspecialchars($test['end_time']) ?></td>
            <td><?= htmlspecialchars($test['topic_id']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
    document.getElementById('downloadPdfBtn').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'landscape' });
        const pageWidth = doc.internal.pageSize.getWidth();

        const collegeLogo = document.getElementById('collegeLogo');
        const iqarenaLogo = document.getElementById('iqarenaLogo');

        Promise.all([
            html2canvas(collegeLogo),
            html2canvas(iqarenaLogo),
            html2canvas(document.getElementById('studentTestTable'))
        ]).then(([collegeCanvas, iqarenaCanvas, tableCanvas]) => {
            const cImg = collegeCanvas.toDataURL('image/png');
            const iImg = iqarenaCanvas.toDataURL('image/png');
            doc.addImage(cImg, 'PNG', pageWidth/2-60, 10, 40, 40);
            doc.addImage(iImg, 'PNG', pageWidth/2+20, 10, 40, 40);

            doc.setFontSize(22);
            doc.setTextColor('#F97316');
            doc.text('IQARENA STUDENT REPORT', pageWidth/2, 60, {align:'center'});

            doc.setFontSize(14);
            doc.setTextColor('#333');

            const name = document.getElementById('pdfName').textContent;
            const dept = document.getElementById('pdfDept').textContent;
            const year = document.getElementById('pdfYear').textContent;
            const roll = document.getElementById('pdfRoll').textContent;

            doc.text(name, pageWidth/2, 70, {align:'center'});
            doc.text(dept, pageWidth/2, 78, {align:'center'});
            doc.text(year, pageWidth/2, 86, {align:'center'});
            doc.text(roll, pageWidth/2, 94, {align:'center'});

            const imgData = tableCanvas.toDataURL('image/png');
            const pdfWidth = pageWidth - 40;
            const imgProps = doc.getImageProperties(imgData);
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

            doc.addImage(imgData, 'PNG', 20, 102, pdfWidth, pdfHeight);
            doc.save('student_details_report.pdf');
        });
    });
    </script>
</body>
</html>
