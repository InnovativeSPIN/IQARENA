<?php
require_once dirname(__DIR__) . '/config/db.php';
require_once dirname(__DIR__) . '/middleware/auth.php'; // For verifyToken()

class UserController
{
    private $conn;

    public function __construct()
    {
        global $conn;
        $this->conn = $conn;
        if (!$this->conn) {
            $this->sendError(500, 'Database connection failed');
        }
    }

    private function sendError($code, $message, $details = null)
    {
        http_response_code($code);
        echo json_encode(['error' => $message, 'details' => $details]);
        exit;
    }

    private function sendSuccess($data = [])
    {
        echo json_encode(array_merge(['success' => true], $data));
        exit;
    }

    // ====================== STUDENTS ======================

    public function getStudents()
    {
        $sql = "
            SELECT u.id, u.name, u.roll_no, u.email, u.department_id, d.short_name AS department_name, u.year
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.role_id = 1
            ORDER BY u.year, u.name
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $this->sendSuccess(['students' => $students]);
    }

    public function getStudentDashboardStats()
    {
        $user = verifyToken(); // From auth middleware
        $userId = $user['id'] ?? null;
        if (!$userId) $this->sendError(401, 'Unauthorized: No user id in token.');

        $stats = [];

        // Total Quizzes
        $sql = "
            SELECT COUNT(*) AS totalQuizzes
            FROM tests
            WHERE is_active = 1
            AND (year IS NULL OR year = (SELECT year FROM users WHERE id = ?))
            AND (department_id IS NULL OR department_id = (SELECT department_id FROM users WHERE id = ?))
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $userId);
        $stmt->execute();
        $stats['totalQuizzes'] = $stmt->get_result()->fetch_assoc()['totalQuizzes'] ?? 0;
        $stmt->close();

        // Completed Quizzes
        $sql = "SELECT COUNT(*) AS completedQuizzes FROM student_tests WHERE student_id = ? AND status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stats['completedQuizzes'] = $stmt->get_result()->fetch_assoc()['completedQuizzes'] ?? 0;
        $stmt->close();

        // Last 7 Days
        $sql = "SELECT COUNT(*) AS completedThisWeek FROM student_tests WHERE student_id = ? AND status = 'completed' AND end_time >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stats['completedThisWeek'] = $stmt->get_result()->fetch_assoc()['completedThisWeek'] ?? 0;
        $stmt->close();

        // Average Score
        $sql = "SELECT COALESCE(AVG(score), 0) AS averageScore FROM student_tests WHERE student_id = ? AND status = 'completed'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stats['averageScore'] = round($stmt->get_result()->fetch_assoc()['averageScore'] ?? 0, 2);
        $stmt->close();

        // Last Month Average
        $sql = "SELECT COALESCE(AVG(score), 0) AS averageScoreLastMonth FROM student_tests WHERE student_id = ? AND status = 'completed' AND end_time >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stats['averageScoreLastMonth'] = round($stmt->get_result()->fetch_assoc()['averageScoreLastMonth'] ?? 0, 2);
        $stmt->close();

        // Rank
        $sql = "
            SELECT student_id, AVG(score) AS avgScore
            FROM student_tests
            WHERE student_id IN (
                SELECT id FROM users 
                WHERE role_id = 1 
                AND year = (SELECT year FROM users WHERE id = ?) 
                AND department_id = (SELECT department_id FROM users WHERE id = ?)
            ) AND status = 'completed'
            GROUP BY student_id
            ORDER BY avgScore DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rank = null;
        $i = 1;
        while ($row = $result->fetch_assoc()) {
            if ($row['student_id'] == $userId) {
                $rank = $i;
                break;
            }
            $i++;
        }
        $stmt->close();

        $stats['rank'] = $rank;
        $stats['rankChange'] = null;

        $this->sendSuccess(['stats' => $stats]);
    }

    public function uploadStudents()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $students = $input['students'] ?? [];

        if (!is_array($students) || empty($students)) {
            $this->sendError(400, 'No students data provided.');
        }

        $stmt = $this->conn->prepare("INSERT INTO users (name, roll_no, email, department_id, year, role_id) VALUES (?, ?, ?, ?, ?, 1)");
        $inserted = 0;

        foreach ($students as $s) {
            $name = $s['name'] ?? '';
            $roll_no = $s['roll'] ?? $s['roll_no'] ?? $s['roll_number'] ?? '';
            $email = $s['email'] ?? '';
            $dept = $s['department'] ?? $s['department_id'] ?? '';
            $year = $s['year'] ?? '';

            if (!$name || !$roll_no || !$email || !$dept || !$year) continue;

            $stmt->bind_param('sssis', $name, $roll_no, $email, $dept, $year);
            if ($stmt->execute()) $inserted++;
        }
        $stmt->close();

        $this->sendSuccess(['inserted' => $inserted]);
    }

    public function deleteStudent($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ? AND role_id = 1");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Student not found or already deleted.');
        $this->sendSuccess(['deleted' => $affected]);
    }

    public function resetStudentPassword($id)
    {
        $hash = password_hash('nscet123', PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ? AND role_id = 1");
        $stmt->bind_param('si', $hash, $id);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Student not found.');
        $this->sendSuccess(['message' => 'Password reset successfully.']);
    }

    public function updateStudent($id)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $fields = []; $values = []; $types = '';

        if (isset($input['roll_no'])) { $fields[] = 'roll_no = ?'; $values[] = $input['roll_no']; $types .= 's'; }
        if (isset($input['name'])) { $fields[] = 'name = ?'; $values[] = $input['name']; $types .= 's'; }
        if (isset($input['email'])) { $fields[] = 'email = ?'; $values[] = $input['email']; $types .= 's'; }
        if (isset($input['department_id'])) { $fields[] = 'department_id = ?'; $values[] = $input['department_id']; $types .= 'i'; }
        if (isset($input['year'])) { $fields[] = 'year = ?'; $values[] = $input['year']; $types .= 's'; }

        if (empty($fields)) $this->sendError(400, 'No fields to update.');

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ? AND role_id = 1";
        $values[] = $id; $types .= 'i';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Student not found.');
        $this->sendSuccess(['updated' => $affected]);
    }

    public function addStudent()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $required = ['name', 'roll_no', 'email', 'department_id', 'year'];
        foreach ($required as $f) {
            if (empty($input[$f])) $this->sendError(400, "Field '$f' is required.");
        }

        $stmt = $this->conn->prepare("INSERT INTO users (name, roll_no, email, department_id, year, role_id) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param('sssisi', $input['name'], $input['roll_no'], $input['email'], $input['department_id'], $input['year']);
        $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();

        $this->sendSuccess(['insertedId' => $insertId]);
    }

    // ====================== FACULTY ======================

    public function getFaculty()
    {
        $sql = "
            SELECT u.id, u.name, u.roll_no, u.email, u.department_id, d.short_name AS department_name
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.role_id = 2
            ORDER BY u.name
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $faculty = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $this->sendSuccess(['faculty' => $faculty]);
    }

    public function resetFacultyPassword($id)
    {
        $hash = password_hash('nscet123', PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ? AND role_id = 2");
        $stmt->bind_param('si', $hash, $id);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Faculty not found.');
        $this->sendSuccess(['message' => 'Password reset successfully.']);
    }

    public function addStaff()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $required = ['name', 'roll_no', 'email', 'department_id'];
        foreach ($required as $f) {
            if (empty($input[$f])) $this->sendError(400, "Field '$f' is required.");
        }

        $stmt = $this->conn->prepare("INSERT INTO users (name, roll_no, email, department_id, role_id) VALUES (?, ?, ?, ?, 2)");
        $stmt->bind_param('sssi', $input['name'], $input['roll_no'], $input['email'], $input['department_id']);
        $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();

        $this->sendSuccess(['insertedId' => $insertId]);
    }

    public function deleteFaculty($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ? AND role_id = 2");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Faculty not found.');
        $this->sendSuccess(['deleted' => $affected]);
    }

    public function updateFaculty($id)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $fields = []; $values = []; $types = '';

        if (isset($input['roll_no'])) { $fields[] = 'roll_no = ?'; $values[] = $input['roll_no']; $types .= 's'; }
        if (isset($input['name'])) { $fields[] = 'name = ?'; $values[] = $input['name']; $types .= 's'; }
        if (isset($input['email'])) { $fields[] = 'email = ?'; $values[] = $input['email']; $types .= 's'; }
        if (isset($input['department_id'])) { $fields[] = 'department_id = ?'; $values[] = $input['department_id']; $types .= 'i'; }

        if (empty($fields)) $this->sendError(400, 'No fields to update.');

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ? AND role_id = 2";
        $values[] = $id; $types .= 'i';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Faculty not found.');
        $this->sendSuccess(['updated' => $affected]);
    }

    public function adminResetPassword()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (empty($input['password'])) $this->sendError(400, 'Password required.');

        $hash = password_hash($input['password'], PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = 1 AND role_id = 5");
        $stmt->bind_param('s', $hash);
        $stmt->execute();
        $stmt->close();

        $this->sendSuccess(['message' => 'Password reset successfully.']);
    }

    public function getProfile()
    {
        $user = verifyToken();
        $userId = $user['id'] ?? null;
        if (!$userId) $this->sendError(401, 'Unauthorized.');

        $stmt = $this->conn->prepare("
            SELECT u.id, u.roll_no, u.name, u.email, u.password, u.year, u.role_id, u.department_id, 
                   d.full_name AS department_name, u.created_at, u.updated_at
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.id = ?
        ");
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $profile = $result->fetch_assoc();
        $stmt->close();

        if (!$profile) $this->sendError(404, 'User not found.');
        $this->sendSuccess(['profile' => $profile]);
    }

    // ====================== HOD: STAFF ======================

    public function getDepartmentStaff()
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $stmt = $this->conn->prepare("SELECT department_id FROM users WHERE id = ? AND role_id = 3");
        $stmt->bind_param('i', $hodId);
        $stmt->execute();
        $dept = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$dept) $this->sendError(404, 'HOD not found.');

        $deptId = $dept['department_id'];
        $stmt = $this->conn->prepare("
            SELECT u.id, u.name, u.roll_no, u.email, u.department_id, d.short_name AS department_name,
                   d.full_name AS department_full_name, u.created_at, 'Faculty' AS role
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            WHERE u.role_id = 2 AND u.department_id = ?
            ORDER BY u.name
        ");
        $stmt->bind_param('i', $deptId);
        $stmt->execute();
        $result = $stmt->get_result();
        $staff = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $this->sendSuccess(['staff' => $staff, 'departmentId' => $deptId]);
    }

    public function getStaffDetails($staffId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        if (!$staffId) $this->sendError(400, 'Staff ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verifySql = "
            SELECT s.id AS staff_id, s.name AS staff_name, s.email, s.roll_no, s.department_id, s.created_at AS staff_joined_date,
                   d.short_name AS department_name, d.full_name AS department_full_name
            FROM users s
            LEFT JOIN departments d ON s.department_id = d.id
            WHERE s.id = ? AND s.role_id = 2 AND s.department_id = (SELECT department_id FROM users WHERE id = ? AND role_id = 3)
        ";
        $stmt = $this->conn->prepare($verifySql);
        $stmt->bind_param('ii', $staffId, $hodId);
        $stmt->execute();
        $result = $stmt->get_result();
        $staffInfo = $result->fetch_assoc();
        $stmt->close();
        if (!$staffInfo) $this->sendError(403, 'Access denied. Staff not in your department.');

        // Tests
        $testsSql = "
            SELECT t.test_id, t.title, t.subject, t.num_questions, t.duration_minutes, t.is_active, t.date, t.time_slot, t.created_at,
                   topic.title AS topic_title, st.title AS sub_topic_title,
                   COUNT(DISTINCT sta.student_id) AS students_attended,
                   COUNT(DISTINCT CASE WHEN sta.status = 'completed' THEN sta.student_id END) AS students_completed
            FROM tests t
            LEFT JOIN topics topic ON t.topic_id = topic.id
            LEFT JOIN sub_topics st ON t.sub_topic_id = st.id
            LEFT JOIN student_tests sta ON t.test_id = sta.test_id
            WHERE t.created_by = ?
            GROUP BY t.test_id
            ORDER BY t.created_at DESC
        ";
        $stmt = $this->conn->prepare($testsSql);
        $stmt->bind_param('i', $staffId);
        $stmt->execute();
        $tests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        // Stats
        $statsSql = "
            SELECT COUNT(DISTINCT t.test_id) AS total_tests,
                   COUNT(DISTINCT CASE WHEN t.is_active = 1 THEN t.test_id END) AS active_tests,
                   COUNT(DISTINCT sta.student_id) AS total_students_participated,
                   COUNT(DISTINCT CASE WHEN sta.status = 'completed' THEN sta.id END) AS total_completed_tests,
                   COALESCE(AVG(sta.score), 0) AS average_score
            FROM tests t
            LEFT JOIN student_tests sta ON t.test_id = sta.test_id
            WHERE t.created_by = ?
        ";
        $stmt = $this->conn->prepare($statsSql);
        $stmt->bind_param('i', $staffId);
        $stmt->execute();
        $stats = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        $this->sendSuccess([
            'staff' => array_merge($staffInfo, ['role' => 'Faculty']),
            'statistics' => $stats,
            'tests' => $tests
        ]);
    }

    public function updateDepartmentStaff($staffId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$staffId) $this->sendError(400, 'Staff ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verify = $this->conn->prepare("SELECT 1 FROM users s JOIN users h ON s.department_id = h.department_id WHERE s.id = ? AND s.role_id = 2 AND h.id = ? AND h.role_id = 3");
        $verify->bind_param('ii', $staffId, $hodId);
        $verify->execute();
        if ($verify->get_result()->num_rows === 0) $this->sendError(403, 'Access denied.');
        $verify->close();

        $fields = []; $values = []; $types = '';
        if (isset($input['name'])) { $fields[] = 'name = ?'; $values[] = $input['name']; $types .= 's'; }
        if (isset($input['email'])) { $fields[] = 'email = ?'; $values[] = $input['email']; $types .= 's'; }
        if (isset($input['roll_no'])) { $fields[] = 'roll_no = ?'; $values[] = $input['roll_no']; $types .= 's'; }

        if (empty($fields)) $this->sendError(400, 'No fields to update.');

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ? AND role_id = 2";
        $values[] = $staffId; $types .= 'i';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Staff not found.');
        $this->sendSuccess(['message' => 'Staff updated successfully.', 'updated' => $affected]);
    }

    public function deleteDepartmentStaff($staffId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        if (!$staffId) $this->sendError(400, 'Staff ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verify = $this->conn->prepare("SELECT 1 FROM users s JOIN users h ON s.department_id = h.department_id WHERE s.id = ? AND s.role_id = 2 AND h.id = ? AND h.role_id = 3");
        $verify->bind_param('ii', $staffId, $hodId);
        $verify->execute();
        if ($verify->get_result()->num_rows === 0) $this->sendError(403, 'Access denied.');
        $verify->close();

        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ? AND role_id = 2");
        $stmt->bind_param('i', $staffId);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Staff not found.');
        $this->sendSuccess(['message' => 'Staff deleted successfully.', 'deleted' => $affected]);
    }

    public function addDepartmentStaff()
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$hodId) $this->sendError(401, 'Unauthorized.');
        if (empty($input['name']) || empty($input['roll_no']) || empty($input['email'])) {
            $this->sendError(400, 'Name, roll number, and email are required.');
        }

        $stmt = $this->conn->prepare("SELECT department_id FROM users WHERE id = ? AND role_id = 3");
        $stmt->bind_param('i', $hodId);
        $stmt->execute();
        $dept = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$dept) $this->sendError(404, 'HOD not found.');

        $password = !empty($input['password']) ? $input['password'] : 'nscet123';
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("INSERT INTO users (name, roll_no, email, password, department_id, role_id) VALUES (?, ?, ?, ?, ?, 2)");
        $stmt->bind_param('ssssi', $input['name'], $input['roll_no'], $input['email'], $hash, $dept['department_id']);
        $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();

        $this->sendSuccess(['message' => 'Staff added successfully.', 'insertedId' => $insertId]);
    }

    public function resetDepartmentStaffPassword($staffId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$staffId) $this->sendError(400, 'Staff ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verify = $this->conn->prepare("SELECT 1 FROM users s JOIN users h ON s.department_id = h.department_id WHERE s.id = ? AND s.role_id = 2 AND h.id = ? AND h.role_id = 3");
        $verify->bind_param('ii', $staffId, $hodId);
        $verify->execute();
        if ($verify->get_result()->num_rows === 0) $this->sendError(403, 'Access denied.');
        $verify->close();

        $password = !empty($input['password']) ? $input['password'] : 'nscet123';
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ? AND role_id = 2");
        $stmt->bind_param('si', $hash, $staffId);
        $stmt->execute();
        $stmt->close();

        $this->sendSuccess(['message' => 'Password reset successfully.']);
    }

    // ====================== HOD: STUDENTS ======================

    public function getDepartmentStudents()
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $sql = "
            SELECT s.id, s.name, s.roll_no, s.email, s.department_id, s.year,
                   d.short_name AS department_name, d.full_name AS department_full_name, s.created_at
            FROM users s
            INNER JOIN departments d ON s.department_id = d.id
            INNER JOIN users h ON s.department_id = h.department_id
            WHERE s.role_id = 1 AND h.id = ? AND h.role_id = 3
            ORDER BY s.year, s.name
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $hodId);
        $stmt->execute();
        $result = $stmt->get_result();
        $students = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $this->sendSuccess(['students' => $students]);
    }

    public function getStudentDetails($studentId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        if (!$studentId) $this->sendError(400, 'Student ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verify = $this->conn->prepare("
            SELECT s.id, s.name, s.roll_no, s.email, s.year, d.short_name AS department_name, d.full_name AS department_full_name, s.created_at AS joined_date
            FROM users s
            INNER JOIN departments d ON s.department_id = d.id
            INNER JOIN users h ON s.department_id = h.department_id
            WHERE s.id = ? AND s.role_id = 1 AND h.id = ? AND h.role_id = 3
        ");
        $verify->bind_param('ii', $studentId, $hodId);
        $verify->execute();
        $result = $verify->get_result();
        $student = $result->fetch_assoc();
        $verify->close();
        if (!$student) $this->sendError(403, 'Access denied.');

        $testsSql = "
            SELECT t.test_id, t.title, t.subject, top.title AS topic_title, st.title AS sub_topic_title,
                   t.duration_minutes, t.num_questions, sta.status, sta.score, sta.start_time, sta.end_time,
                   sta.time_taken_minutes, u.name AS created_by_name
            FROM student_tests sta
            INNER JOIN tests t ON sta.test_id = t.test_id
            LEFT JOIN topics top ON t.topic_id = top.id
            LEFT JOIN sub_topics st ON t.sub_topic_id = st.id
            LEFT JOIN users u ON t.created_by = u.id
            WHERE sta.student_id = ?
            ORDER BY sta.start_time DESC
        ";
        $stmt = $this->conn->prepare($testsSql);
        $stmt->bind_param('i', $studentId);
        $stmt->execute();
        $testsResult = $stmt->get_result();
        $tests = $testsResult->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        $completed = array_filter($tests, fn($t) => $t['status'] === 'completed');
        $total = count($tests);
        $avg = count($completed) > 0 ? array_sum(array_column($completed, 'score')) / count($completed) : 0;

        $this->sendSuccess([
            'student' => array_merge($student, ['role' => 'Student']),
            'tests' => $tests,
            'statistics' => [
                'total_tests_attended' => $total,
                'tests_completed' => count($completed),
                'tests_in_progress' => $total - count($completed),
                'average_score' => round($avg, 2)
            ]
        ]);
    }

    public function addDepartmentStudent()
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$hodId) $this->sendError(401, 'Unauthorized.');
        if (empty($input['name']) || empty($input['roll_no']) || empty($input['email']) || empty($input['year'])) {
            $this->sendError(400, 'Name, roll number, email, and year are required.');
        }

        $stmt = $this->conn->prepare("SELECT department_id FROM users WHERE id = ? AND role_id = 3");
        $stmt->bind_param('i', $hodId);
        $stmt->execute();
        $dept = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if (!$dept) $this->sendError(403, 'HOD not found.');

        $password = !empty($input['password']) ? $input['password'] : 'nscet123';
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("INSERT INTO users (name, roll_no, email, department_id, year, role_id, password) VALUES (?, ?, ?, ?, ?, 1, ?)");
        $stmt->bind_param('sssis' . (is_numeric($input['year']) ? 'i' : 's') . 'ss', $input['name'], $input['roll_no'], $input['email'], $dept['department_id'], $input['year'], $hash);
        $stmt->execute();
        $insertId = $stmt->insert_id;
        $stmt->close();

        $this->sendSuccess(['message' => 'Student added successfully.', 'insertedId' => $insertId]);
    }

    public function updateDepartmentStudent($studentId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$studentId) $this->sendError(400, 'Student ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verify = $this->conn->prepare("SELECT 1 FROM users s JOIN users h ON s.department_id = h.department_id WHERE s.id = ? AND s.role_id = 1 AND h.id = ? AND h.role_id = 3");
        $verify->bind_param('ii', $studentId, $hodId);
        $verify->execute();
        if ($verify->get_result()->num_rows === 0) $this->sendError(403, 'Access denied.');
        $verify->close();

        $fields = []; $values = []; $types = '';
        if (isset($input['name'])) { $fields[] = 'name = ?'; $values[] = $input['name']; $types .= 's'; }
        if (isset($input['roll_no'])) { $fields[] = 'roll_no = ?'; $values[] = $input['roll_no']; $types .= 's'; }
        if (isset($input['email'])) { $fields[] = 'email = ?'; $values[] = $input['email']; $types .= 's'; }
        if (isset($input['year'])) { $fields[] = 'year = ?'; $values[] = $input['year']; $types .= (is_numeric($input['year']) ? 'i' : 's'); }

        if (empty($fields)) $this->sendError(400, 'No fields to update.');

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ? AND role_id = 1";
        $values[] = $studentId; $types .= 'i';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Student not found.');
        $this->sendSuccess(['message' => 'Student updated successfully.', 'updated' => $affected]);
    }

    public function deleteDepartmentStudent($studentId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        if (!$studentId) $this->sendError(400, 'Student ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verify = $this->conn->prepare("SELECT 1 FROM users s JOIN users h ON s.department_id = h.department_id WHERE s.id = ? AND s.role_id = 1 AND h.id = ? AND h.role_id = 3");
        $verify->bind_param('ii', $studentId, $hodId);
        $verify->execute();
        if ($verify->get_result()->num_rows === 0) $this->sendError(403, 'Access denied.');
        $verify->close();

        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ? AND role_id = 1");
        $stmt->bind_param('i', $studentId);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        if ($affected === 0) $this->sendError(404, 'Student not found.');
        $this->sendSuccess(['message' => 'Student deleted successfully.', 'deleted' => $affected]);
    }

    public function resetDepartmentStudentPassword($studentId)
    {
        $user = verifyToken();
        $hodId = $user['id'] ?? null;
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$studentId) $this->sendError(400, 'Student ID required.');
        if (!$hodId) $this->sendError(401, 'Unauthorized.');

        $verify = $this->conn->prepare("SELECT 1 FROM users s JOIN users h ON s.department_id = h.department_id WHERE s.id = ? AND s.role_id = 1 AND h.id = ? AND h.role_id = 3");
        $verify->bind_param('ii', $studentId, $hodId);
        $verify->execute();
        if ($verify->get_result()->num_rows === 0) $this->sendError(403, 'Access denied.');
        $verify->close();

        $password = !empty($input['password']) ? $input['password'] : 'nscet123';
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ? AND role_id = 1");
        $stmt->bind_param('si', $hash, $studentId);
        $stmt->execute();
        $stmt->close();

        $this->sendSuccess(['message' => 'Password reset successfully.']);
    }
}