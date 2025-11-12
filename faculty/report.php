<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

require_once '../resource/conn.php';
require_once '../resource/session.php';

if (!$conn) {
    die('<div class="error">Database Connection Failed: ' . htmlspecialchars(mysqli_connect_error()) . '</div>');
}

// Filters
$department = $_POST['department'] ?? '';
$time_filter = $_POST['time_filter'] ?? '';
$year = $_POST['year'] ?? '';
$test_id = $_POST['test_id'] ?? '';

// Departments
$departments = [];
$res = mysqli_query($conn, "SELECT id, full_name FROM departments ORDER BY full_name ASC");
while ($r = mysqli_fetch_assoc($res)) $departments[] = $r;

// Tests
$test_list = [];
$res = mysqli_query($conn, "SELECT test_id, title FROM tests ORDER BY test_id DESC");
while ($r = mysqli_fetch_assoc($res)) $test_list[] = $r;

// Test details
$test_info = [];
$total_test_mark = 0;
if (!empty($test_id)) {
    $stmt = mysqli_prepare($conn, "
        SELECT 
            t.title AS test_name, t.description, t.subject,
            t.duration_minutes, t.num_questions AS total_questions,
            tp.title AS topic_title, stp.title AS sub_topic_title,
            d.full_name AS department_name, t.year, t.date, t.time_slot
        FROM tests t
        LEFT JOIN topics tp ON t.topic_id = tp.topic_id
        LEFT JOIN sub_topics stp ON t.sub_topic_id = stp.sub_topic_id
        LEFT JOIN departments d ON t.department_id = d.id
        WHERE t.test_id = ?
    ");
    mysqli_stmt_bind_param($stmt, 'i', $test_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $test_info = mysqli_fetch_assoc($result) ?? [];
    mysqli_stmt_close($stmt);

    // Total marks
    $stmt = mysqli_prepare($conn, "
        SELECT SUM(q.mark) AS total_mark 
        FROM test_questions tq 
        JOIN questions q ON tq.question_id = q.question_id
        WHERE tq.test_id = ?
    ");
    mysqli_stmt_bind_param($stmt, 'i', $test_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $mark = mysqli_fetch_assoc($result);
    $total_test_mark = $mark['total_mark'] ?? 0;
    mysqli_stmt_close($stmt);
}

$test_info = array_merge([
    'test_name' => '',
    'description' => '',
    'subject' => '',
    'department_name' => '',
    'topic_title' => '',
    'sub_topic_title' => '',
    'year' => '',
    'date' => '',
    'time_slot' => '',
    'total_questions' => '',
    'duration_minutes' => ''
], $test_info);

// Student results
$params = [];
$types = '';
$where = [];
$q = "SELECT u.roll_no, u.name, u.year, d.full_name AS department, st.score, st.end_time
      FROM student_tests st
      JOIN users u ON st.student_id = u.id
      LEFT JOIN departments d ON u.department_id = d.id
      WHERE 1=1";

if ($department) { $where[] = "d.id=?"; $params[] = $department; $types.='i'; }
if ($year) { $where[] = "u.year=?"; $params[] = $year; $types.='s'; }
if ($test_id) { $where[] = "st.test_id=?"; $params[] = $test_id; $types.='i'; }

if ($time_filter) {
    $today = date('Y-m-d');
    switch ($time_filter) {
        case 'day': $where[] = "DATE(st.end_time)=?"; $params[]=$today; $types.='s'; break;
        case 'week': 
            $start=date('Y-m-d',strtotime('monday this week'));
            $end=date('Y-m-d',strtotime('sunday this week'));
            $where[]="DATE(st.end_time) BETWEEN ? AND ?"; $params[]=$start; $params[]=$end; $types.='ss'; break;
        case 'month':
            $start=date('Y-m-01'); $end=date('Y-m-t');
            $where[]="DATE(st.end_time) BETWEEN ? AND ?"; $params[]=$start; $params[]=$end; $types.='ss'; break;
    }
}
if ($where) $q .= ' AND '.implode(' AND ', $where);
$q .= " ORDER BY st.end_time DESC";

$rows=[];
$stmt=mysqli_prepare($conn,$q);
if($stmt){
    if($params) mysqli_stmt_bind_param($stmt,$types,...$params);
    mysqli_stmt_execute($stmt);
    $res=mysqli_stmt_get_result($stmt);
    while($r=mysqli_fetch_assoc($res)) $rows[]=$r;
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IQArena Student Reports</title>
<style>
:root {
  --orange: #F97316;
  --orange-dark: #EA580C;
  --border: #ddd;
}
body { font-family: 'Segoe UI', sans-serif; background:#fafafa; padding:2rem; }
h2 { text-align:center; color:var(--orange); margin-bottom:1rem; }
.filter-nav { display:flex;flex-wrap:wrap;gap:1rem;justify-content:center;background:#fff;padding:1rem;border-radius:10px;box-shadow:0 4px 6px rgba(0,0,0,0.1);}
button { background:var(--orange); color:#fff; border:none; padding:.6rem 1.2rem; border-radius:6px; cursor:pointer; }
button:hover { background:var(--orange-dark); }
.test-info { background:#fff; padding:1rem; border-radius:10px; box-shadow:0 3px 8px rgba(0,0,0,0.1); margin-top:1rem;}
table { width:100%; border-collapse:collapse; background:#fff; margin-top:1rem; box-shadow:0 3px 8px rgba(0,0,0,0.1);}
th,td { padding:0.8rem; border-bottom:1px solid var(--border); text-align:left;}
th { background:var(--orange); color:#fff; }
tr:nth-child(even){ background:#f9f9f9; }

/* Popup modal */
#pdfModal {
  display:none;
  position:fixed;
  inset:0;
  background:rgba(0,0,0,0.6);
  z-index:1000;
  align-items:center;
  justify-content:center;
}
#pdfContainer {
  background:#fff;
  border-radius:10px;
  width:90%;
  height:90%;
  display:flex;
  flex-direction:column;
  overflow:hidden;
}
#pdfContainer header {
  background:var(--orange);
  color:white;
  text-align:center;
  padding:.5rem;
  font-weight:bold;
}
#pdfViewer {
  flex:1;
  width:100%;
  border:none;
}
#closeModal {
  position:absolute;
  top:20px;
  right:40px;
  font-size:18px;
  background:#fff;
  border:none;
  color:#444;
  padding:5px 10px;
  border-radius:6px;
  cursor:pointer;
  box-shadow:0 2px 6px rgba(0,0,0,0.2);
}
#closeModal:hover { background:#eee; }
</style>
</head>
<body>

<h2>NSCET IQArena – Student Reports</h2>

<form method="post" class="filter-nav">
  <label>Department:</label>
  <select name="department">
    <option value="">All</option>
    <?php foreach($departments as $d): ?>
      <option value="<?= $d['id'] ?>" <?= $department==$d['id']?'selected':'' ?>><?= htmlspecialchars($d['full_name']) ?></option>
    <?php endforeach; ?>
  </select>

  <label>Year:</label>
  <select name="year">
    <option value="">All</option>
    <option value="1" <?= $year==='1'?'selected':'' ?>>1st</option>
    <option value="2" <?= $year==='2'?'selected':'' ?>>2nd</option>
    <option value="3" <?= $year==='3'?'selected':'' ?>>3rd</option>
    <option value="4" <?= $year==='4'?'selected':'' ?>>4th</option>
  </select>

  <label>Test:</label>
  <select name="test_id">
    <option value="">All</option>
    <?php foreach($test_list as $t): ?>
      <option value="<?= $t['test_id'] ?>" <?= $test_id==$t['test_id']?'selected':'' ?>><?= htmlspecialchars($t['title']) ?></option>
    <?php endforeach; ?>
  </select>

  <label>Time:</label>
  <select name="time_filter">
    <option value="">All</option>
    <option value="day" <?= $time_filter==='day'?'selected':'' ?>>Today</option>
    <option value="week" <?= $time_filter==='week'?'selected':'' ?>>This Week</option>
    <option value="month" <?= $time_filter==='month'?'selected':'' ?>>This Month</option>
  </select>

  <button type="submit">Apply</button>
  <button type="button" onclick="window.location.href='report.php'" style="background:#6b7280;">Reset</button>
</form>

<?php if($test_info['test_name']): ?>
<div class="test-info">
  <h3 style="color:#F97316;">Test Information</h3>
  <p><strong>Title:</strong> <?= htmlspecialchars($test_info['test_name']) ?></p>
  <p><strong>Description:</strong> <?= htmlspecialchars($test_info['description']) ?></p>
  <p><strong>Subject:</strong> <?= htmlspecialchars($test_info['subject']) ?></p>
  <p><strong>Department:</strong> <?= htmlspecialchars($test_info['department_name']) ?></p>
  <p><strong>Topic:</strong> <?= htmlspecialchars($test_info['topic_title']) ?></p>
  <p><strong>Subtopic:</strong> <?= htmlspecialchars($test_info['sub_topic_title']) ?></p>
  <p><strong>Year:</strong> <?= htmlspecialchars($test_info['year']) ?></p>
  <p><strong>Date:</strong> <?= htmlspecialchars($test_info['date']) ?> </p>
  <p><strong>Total Questions:</strong> <?= htmlspecialchars($test_info['total_questions']) ?></p>
  <p><strong>Duration:</strong> <?= htmlspecialchars($test_info['duration_minutes']) ?> mins</p>
  <p><strong>Total Test Marks:</strong> <?= htmlspecialchars($total_test_mark) ?></p>
</div>
<?php endif; ?>

<button id="previewBtn">Preview PDF</button>

<div id="report-content">
<?php if(!$rows): ?>
  <div class="error">No records found.</div>
<?php else: ?>
  <table>
    <tr><th>S.No</th><th>Roll No</th><th>Name</th><th>Department</th><th>Year</th><th>Date</th><th>Score (Out of <?= htmlspecialchars($total_test_mark) ?>)</th></tr>
    <?php $i=1; foreach($rows as $r): ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($r['roll_no']) ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['department']) ?></td>
        <td><?= htmlspecialchars($r['year']) ?></td>
        <td><?= htmlspecialchars($r['end_time']) ?></td>
        <td><?= htmlspecialchars($r['score']) ?> / <?= htmlspecialchars($total_test_mark) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
</div>

<!-- Popup Modal -->
<div id="pdfModal">
  <div id="pdfContainer">
    <header>PDF Preview – NSCET IQArena Report</header>
    <button id="closeModal">Close ✖</button>
    <iframe id="pdfViewer"></iframe>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.0/jspdf.plugin.autotable.min.js"></script>
<script>
const modal = document.getElementById('pdfModal');
const closeBtn = document.getElementById('closeModal');
const viewer = document.getElementById('pdfViewer');
closeBtn.onclick = ()=> modal.style.display='none';

document.getElementById('previewBtn').addEventListener('click', () => {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ orientation:'landscape', unit:'pt', format:'a4' });
  const width = doc.internal.pageSize.getWidth();
  const height = doc.internal.pageSize.getHeight();
  const dateStr = new Date().toLocaleString();

  // --- Gradient Header ---
  const gradient = doc.context2d.createLinearGradient(0, 0, width, 0);
  doc.setFillColor(249,115,22);
  doc.rect(0, 0, width, 70, 'F');
  doc.setFontSize(26);
  doc.setTextColor(255,255,255);
  doc.setFont('helvetica','bold');
  doc.text('NSCET IQArena Test Report', width/2, 45, { align:'center' });
  doc.setFontSize(11);
  doc.setTextColor(230);
  doc.text(`Generated on ${dateStr}`, width/2, 62, { align:'center' });

  // --- Section Title for Test Info ---
  doc.setFillColor(240,240,240);
  doc.roundedRect(40, 85, width-80, 30, 6, 6, 'F');
  doc.setTextColor(80);
  doc.setFontSize(14);
  doc.setFont('helvetica','bold');
  doc.text('TEST INFORMATION', 55, 105);

  // --- Test Info Layout (Stylish Info Box Grid) ---
  const testInfoEl = document.querySelector('.test-info');
  let infoMap = [];
  if(testInfoEl){
    infoMap = Array.from(testInfoEl.querySelectorAll('p')).map(p => p.innerText.split(':'));
  }
  
  const startX = 55;
  let y = 130;
  const boxWidth = (width - 130) / 2;
  const boxHeight = 28;
  const colors = [[255,250,240],[255,245,230]]; // subtle alternating tones
  
  doc.setFontSize(11);
  doc.setFont('helvetica','normal');
  
  infoMap.forEach((pair, idx) => {
    const col = idx % 2;
    const row = Math.floor(idx / 2);
    const x = startX + col * (boxWidth + 20);
    const bg = colors[idx % 2];
    doc.setFillColor(bg[0], bg[1], bg[2]);
    doc.roundedRect(x, y + (row * (boxHeight + 8)), boxWidth, boxHeight, 6, 6, 'F');
    doc.setTextColor(60);
    doc.setFont('helvetica','bold');
    doc.text((pair[0] || '').trim() + ':', x + 10, y + (row * (boxHeight + 8)) + 18);
    doc.setFont('helvetica','normal');
    doc.setTextColor(90);
    doc.text((pair[1] || '').trim(), x + 110, y + (row * (boxHeight + 8)) + 18);
  });

  // Adjust for table start position
  const tableStartY = y + (Math.ceil(infoMap.length / 2) * (boxHeight + 8)) + 25;

  // --- Table (Student Results) ---
  const table = document.querySelector('#report-content table');
  if(!table){ alert('No data available.'); return; }
  
  const rows = [], head = [];
  table.querySelectorAll('tr').forEach((tr,i)=>{
    const cells = Array.from(tr.querySelectorAll(i===0?'th':'td')).map(c=>c.innerText.trim());
    if(i===0) head.push(cells); else rows.push(cells);
  });

  doc.autoTable({
    startY: tableStartY,
    head: head,
    body: rows,
    styles: {
      fontSize: 9,
      halign: 'center',
      valign: 'middle',
      lineColor: [220,220,220],
      lineWidth: 0.3
    },
    headStyles: {
      fillColor: [249,115,22],
      textColor: 255,
      fontStyle: 'bold',
      halign: 'center'
    },
    alternateRowStyles: { fillColor: [255,250,240] },
    tableLineColor: [240,240,240],
    tableLineWidth: 0.4,
    margin: { left: 40, right: 40 },
    theme: 'grid'
  });

  // --- Footer ---
  const totalPages = doc.internal.getNumberOfPages();
  for(let i=1; i<=totalPages; i++){
    doc.setPage(i);
    doc.setFillColor(249,115,22);
    doc.rect(0, height-30, width, 30, 'F');
    doc.setFontSize(9);
    doc.setTextColor(255);
    doc.text('© NSCET IQArena | Generated Report', 40, height-12);
    doc.text(`Page ${i} of ${totalPages}`, width-70, height-12);
  }

  // --- Watermark ---
  doc.setFontSize(60);
  doc.setTextColor(245,245,245);
  doc.text('NSCET IQArena', width/2, height/2, { align:'center', angle:30 });

  // --- Show popup preview ---
  const pdfDataUri = doc.output('datauristring');
  viewer.src = pdfDataUri;
  modal.style.display = 'flex';
});
</script>

</body>
</html>
