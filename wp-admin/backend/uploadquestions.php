<?php
ob_start();
session_start();
include("../../resource/conn.php");

if (isset($_POST['importExcelFile'])) {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $csvFileTmpName = $_FILES['csvFile']['tmp_name'];

        if (($handle = fopen($csvFileTmpName, 'r')) !== false) {

            $header = fgetcsv($handle, 1000, ',');
            $header = array_map(function($h) {
                return strtolower(trim($h));
            }, $header);

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $row = array_combine($header, $data);

                $stu_name   = $conn->real_escape_string($row['name']);
                $inputRegNo = $conn->real_escape_string($row['reg_no']);
                $dept       = $conn->real_escape_string($row['dept']);
                $stu_batch  = $conn->real_escape_string($row['year']);

                $batch_year = [
                    "2022" => "IV",
                    "2023" => "III",
                    "2024" => "II",
                    "2025" => "I"
                ];
                $year = isset($batch_year[$stu_batch]) ? $batch_year[$stu_batch] : $stu_batch;

                $inputRegNo = !empty($inputRegNo) ? $inputRegNo : (isset($row['admission_no']) ? $row['admission_no'] : '');

                $house_name = $conn->real_escape_string($_POST['house_name']);
                $gender     = $conn->real_escape_string($_POST['gender']);

                $sql = "INSERT INTO studentdb (name, reg_no, house, dept, gender, year) 
                        VALUES ('$stu_name', '$inputRegNo', '$house_name', '$dept', '$gender', '$year')
                        ON DUPLICATE KEY UPDATE
                            name='$stu_name',
                            house='$house_name',
                            dept='$dept',
                            gender='$gender',
                            year='$year'";

                $result = $conn->query($sql);

                if (!$result) {
                    die("Error: " . $conn->error);
                }
            }

            fclose($handle);
        }
    }

    $conn->close();
    header('Location: ../../pages/adminForm.php');
}
ob_end_flush();
