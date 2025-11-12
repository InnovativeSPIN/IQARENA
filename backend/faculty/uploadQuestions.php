<?php
include("../../resource/conn.php");
include("../../resource/session.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sub_topic_id = isset($_POST['sub_topic_id']) ? $_POST['sub_topic_id'] : ($_POST['subtopic_id'] ?? null);
    $topic_id = isset($_POST['topic_id']) ? intval($_POST['topic_id']) : 0;
    if (empty($sub_topic_id)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => "Missing field: sub_topic_id"]);
        exit;
    }
    $sub_topic_id = intval($sub_topic_id);
    $created_by = $_SESSION['id'];
    $by_admin = 0;

    // File upload handling
    if (!isset($_FILES['questionsFile']) || $_FILES['questionsFile']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'File upload error']);
        exit;
    }
    $fileTmp = $_FILES['questionsFile']['tmp_name'];
    $fileName = $_FILES['questionsFile']['name'];
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $questions = [];
    if ($ext === 'csv') {
        // Parse CSV
        if (($handle = fopen($fileTmp, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($row = fgetcsv($handle)) !== false) {
                if (count($header) === count($row)) {
                    $q = array_combine($header, $row);
                    $questions[] = $q;
                }
                // else: skip row or log error
            }
            fclose($handle);
        }
    } elseif (in_array($ext, ['xlsx', 'xlsm'])) {
        // Parse Excel
        require_once '../../vendor/autoload.php';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmp);
        $sheet = $spreadsheet->getActiveSheet();
        $header = [];
        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
            if ($rowIndex == 1) {
                $header = $rowData;
            } else {
                if (count($header) === count($rowData)) {
                    $questions[] = array_combine($header, $rowData);
                }
                // else: skip row or log error
            }
        }
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Unsupported file type']);
        exit;
    }

    // Insert questions
    $stmt = $conn->prepare("INSERT INTO questions (sub_topic_id, created_by, by_admin, question_text, option_a, option_b, option_c, option_d, correct_option, mark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $successCount = 0;
    $insertedIds = [];
    foreach ($questions as $q) {
        $question_text = trim($q['Question Text'] ?? '');
        $option_a = trim($q['Option A'] ?? '');
        $option_b = trim($q['Option B'] ?? '');
        $option_c = trim($q['Option C'] ?? '');
        $option_d = trim($q['Option D'] ?? '');
        $correct_option = strtoupper(trim($q['Correct Option'] ?? ''));
        $mark = intval($q['Mark'] ?? 1);
        if (!$question_text || !$option_a || !$option_b || !$option_c || !$option_d || !in_array($correct_option, ['A','B','C','D'])) {
            continue;
        }
        $stmt->bind_param("iiissssssi", $sub_topic_id, $created_by, $by_admin, $question_text, $option_a, $option_b, $option_c, $option_d, $correct_option, $mark);
        if ($stmt->execute()) {
            $successCount++;
            $insertedIds[] = $stmt->insert_id;
        }
    }
    $stmt->close();
    // Redirect to uploaded-questions.php with topic_id, sub_topic_id, and inserted question IDs
    $idsParam = implode(',', $insertedIds);
    header("Location: ../../faculty/uploaded-questions.php?topic_id=$topic_id&sub_topic_id=$sub_topic_id&ids=$idsParam&success=1");
    exit;
}

// If not POST, show error
http_response_code(405);
echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
exit;
