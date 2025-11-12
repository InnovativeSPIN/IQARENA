<?php
require_once '../resource/conn.php'; 
require_once '../resource/session.php'; 

$student_id = $_SESSION['user_id'] ?? null;
if (!$student_id) {
    echo '<div class="error">You must be logged in to view your report.</div>';
    exit;
}

$time_filter = $_POST['time_filter'] ?? '';
$year = $_POST['year'] ?? '';

$where = ["u.id = '" . mysqli_real_escape_string($conn, $student_id) . "'"];
if ($year) {
    $where[] = "u.year = '" . mysqli_real_escape_string($conn, $year) . "'";
}
if ($time_filter) {
    $today = date('Y-m-d');
    if ($time_filter == 'day') {
        $where[] = "DATE(st.end_time) = '$today'";
    } elseif ($time_filter == 'week') {
        $week_start = date('Y-m-d', strtotime('monday this week'));
        $week_end = date('Y-m-d', strtotime('sunday this week'));
        $where[] = "st.end_time BETWEEN '$week_start' AND '$week_end'";
    } elseif ($time_filter == 'month') {
        $month = date('m');
        $year_now = date('Y');
        $where[] = "MONTH(st.end_time) = '$month' AND YEAR(st.end_time) = '$year_now'";
    }
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Fetch report data with JOINs
$sql = "SELECT u.id AS student_id, u.name AS student_name, d.full_name AS department, u.year, st.end_time AS test_date, st.score FROM student_tests st JOIN users u ON st.student_id = u.id LEFT JOIN departments d ON u.department_id = d.id $where_sql ORDER BY st.end_time DESC";
$result = mysqli_query($conn, $sql);
$rows = [];
if ($result === false) {
    echo '<div class="error">SQL Error: ' . htmlspecialchars(mysqli_error($conn)) . '</div>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Report</title>
    <style>
        :root {
            --color-primary: #F97316;
            --color-primary-hover: #EA580C;
            --color-secondary: #FF8C00;
            --color-accent: #FFA500;
            --color-text: #333;
            --color-border: #e0e0e0;
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
        form {
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        label {
            font-weight: 600;
            color: var(--color-text);
        }
        select, button {
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-size: 1rem;
            border: 1px solid var(--color-border);
        }
        select {
            background-color: #f9f9f9;
            cursor: pointer;
        }
        select:focus {
            outline: none;
            border-color: var(--color-primary);
        }
        button {
            background-color: var(--color-primary);
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: var(--color-primary-hover);
        }
        .table-container {
            max-width: 100%;
            overflow-x: auto;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--color-border);
        }
        th {
            background-color: var(--color-secondary);
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        td {
            color: var(--color-text);
            font-size: 0.95rem;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-details {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--color-primary);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .btn-details:hover {
            background-color: var(--color-primary-hover);
        }
        @media (max-width: 768px) {
            .table-container {
                padding: 0.5rem;
            }
            th, td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
            .btn-details {
                padding: 0.4rem 0.8rem;
                font-size: 0.9rem;
            }
        }
        @media (max-width: 600px) {
            form {
                flex-direction: column;
                align-items: stretch;
            }
            select, button {
                width: 100%;
            }
            th, td {
                font-size: 0.85rem;
                padding: 0.5rem;
            }
            .btn-details {
                width: 100%;
                display: block;
            }
        }
    </style>
</head>
<body>
    <h2>My Report</h2>
    <button id="downloadPdfBtn" class="btn-details" style="margin-bottom:1rem;">Download PDF</button>
    <form method="post">
        <label for="time_filter">Time:</label>
        <select name="time_filter" id="time_filter">
            <option value="">All</option>
            <option value="day" <?= $time_filter=='day'?'selected':'' ?>>Day</option>
            <option value="week" <?= $time_filter=='week'?'selected':'' ?>>Week</option>
            <option value="month" <?= $time_filter=='month'?'selected':'' ?>>Month</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    <div id="report-content" class="table-container">
        <table>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Year</th>
                    <th scope="col">Date</th>
                    <th scope="col">Score</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['student_id']) ?></td>
                    <td><?= htmlspecialchars($r['student_name']) ?></td>
                    <td><?= htmlspecialchars($r['department']) ?></td>
                    <td><?= htmlspecialchars($r['year']) ?></td>
                    <td><?= htmlspecialchars($r['test_date']) ?></td>
                    <td><?= htmlspecialchars($r['score']) ?></td>
                    <td>
                        <a href="test_details.php?student_id=<?= urlencode($r['student_id']) ?>&test_date=<?= urlencode($r['test_date']) ?>" class="btn-details">View Details</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.getElementById('downloadPdfBtn').addEventListener('click', async function() {
    // Check if content exists
    const content = document.getElementById('report-content');
    if (!content || !content.querySelector('table')) {
        alert('No data available to generate PDF.');
        return;
    }

    // Clone table and remove Action column if present
    const table = content.querySelector('table');
    const tableClone = table.cloneNode(true);
    const isDetailsPage = window.location.href.includes('test_details.php');
    
    if (!isDetailsPage) {
        // Remove Action column for main report
        const headerRow = tableClone.querySelector('tr');
        if (headerRow && headerRow.lastElementChild) {
            headerRow.removeChild(headerRow.lastElementChild);
        }
        const dataRows = tableClone.querySelectorAll('tbody tr');
        dataRows.forEach(row => {
            if (row.lastElementChild) {
                row.removeChild(row.lastElementChild);
            }
        });
    }

    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ orientation: 'landscape' });

    // Report metadata
    const departmentName = 'Computer Science';
    const selectedYear = '<?= $year ? $year : "All" ?>';
    const reportDate = new Date().toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Load images with fallback
    const collegeLogoUrl = 'assets/img/logo/logo.png';
    const iqarenaLogoUrl = 'assets/img/logo/iqarena.png';

    async function loadImage(url) {
        try {
            const img = new Image();
            img.crossOrigin = 'Anonymous';
            return new Promise((resolve) => {
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                };
                img.onerror = () => resolve(null);
                img.src = url;
            });
        } catch (error) {
            console.warn(`Failed to load image: ${url}`, error);
            return null;
        }
    }

    try {
        // Load logos
        const [collegeLogo, iqarenaLogo] = await Promise.all([
            loadImage(collegeLogoUrl),
            loadImage(iqarenaLogoUrl)
        ]);

        // Header
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(20);
        doc.setTextColor(249, 115, 22); // Primary color
        const pageWidth = doc.internal.pageSize.getWidth();
        doc.text('NSCET IQArena Report', pageWidth / 2, 20, { align: 'center' });

        // Subheader
        doc.setFontSize(12);
        doc.setTextColor(51, 51, 51);
        doc.setFont('helvetica', 'normal');
        const subHeader = `Department: ${departmentName} | Year: ${selectedYear} | Generated: ${reportDate}`;
        doc.text(subHeader, pageWidth / 2, 30, { align: 'center' });

        // Logos
        if (collegeLogo) {
            doc.addImage(collegeLogo, 'PNG', 14, 8, 30, 18);
        }
        if (iqarenaLogo) {
            doc.addImage(iqarenaLogo, 'PNG', pageWidth - 44, 8, 30, 18);
        }

        // Horizontal line
        doc.setDrawColor(200, 200, 200);
        doc.setLineWidth(0.5);
        doc.line(14, 35, pageWidth - 14, 35);

        // Capture table or content
        const canvas = await html2canvas(content, { 
            scale: 2,
            useCORS: true,
            logging: false
        });
        const imgData = canvas.toDataURL('image/png');
        const imgProps = doc.getImageProperties(imgData);
        const pdfWidth = pageWidth - 28; // Margin
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        // Check if content fits on one page
        const pageHeight = doc.internal.pageSize.getHeight();
        let yPosition = 40;
        if (pdfHeight > pageHeight - 50) {
            // Multi-page handling
            const scaleFactor = (pageHeight - 50) / pdfHeight;
            doc.addImage(imgData, 'PNG', 14, yPosition, pdfWidth * scaleFactor, pdfHeight * scaleFactor);
        } else {
            doc.addImage(imgData, 'PNG', 14, yPosition, pdfWidth, pdfHeight);
        }

        // Footer
        doc.setFontSize(10);
        doc.setTextColor(100, 100, 100);
        doc.text('Generated by NSCET IQArena System', 14, pageHeight - 10);

        // Save PDF
        doc.save(`NSCET_IQArena_Report_${reportDate.replace(/, /g, '_')}.pdf`);
    } catch (error) {
        console.error('Error generating PDF:', error);
        alert('Failed to generate PDF. Please try again.');
    }
});
</script>
</body>
</html>