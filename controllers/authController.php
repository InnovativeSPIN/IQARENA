<?php
// api/controllers/authController.php
include_once(dirname(__DIR__) . '/config/db.php');

function getUserByRollNo($rollNo) {
    global $conn;
    $sql = "SELECT u.roll_no, u.name, r.role_name, u.email, d.full_name AS department
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            LEFT JOIN roles r ON u.role_id = r.role_id
            WHERE u.roll_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $rollNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) return null;
    return $result->fetch_assoc();
}

function signup($rollNo, $password) {
    global $conn;
    $sql = "SELECT password FROM users WHERE roll_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $rollNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) return ['error' => 'User not found'];
    $row = $result->fetch_assoc();
    if (!empty($row['password'])) return ['error' => 'Password already set for this user'];
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE roll_no = ?");
    $update->bind_param('ss', $hashed, $rollNo);
    $update->execute();
    return ['success' => true];
}

function login($rollNo, $password) {
    global $conn;
    $sql = "SELECT u.id, u.roll_no, u.name, u.email, d.full_name AS department, u.password, u.role_id, r.role_name
            FROM users u
            LEFT JOIN departments d ON u.department_id = d.id
            LEFT JOIN roles r ON u.role_id = r.role_id
            WHERE u.roll_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $rollNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) return ['error' => 'User not found'];
    $user = $result->fetch_assoc();
    if (empty($user['password'])) return ['error' => 'Password not set. Please sign up.'];
    if (!password_verify($password, $user['password'])) return ['error' => 'Invalid password'];
    // JWT generation would go here (stub)
    return ['success' => true, 'user' => $user];
}

function updateProfile($userId, $name, $email) {
    global $conn;
    $check = $conn->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
    $check->bind_param('si', $email, $userId);
    $check->execute();
    $result = $check->get_result();
    if ($result->num_rows > 0) return ['error' => 'Email already exists'];
    $update = $conn->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
    $update->bind_param('ssi', $name, $email, $userId);
    $update->execute();
    if ($update->affected_rows === 0) return ['error' => 'User not found'];
    return ['success' => true, 'message' => 'Profile updated successfully'];
}

function resetPassword($userId, $currentPassword, $newPassword) {
    global $conn;
    $get = $conn->prepare('SELECT password FROM users WHERE id = ?');
    $get->bind_param('i', $userId);
    $get->execute();
    $result = $get->get_result();
    if ($result->num_rows === 0) return ['error' => 'User not found'];
    $row = $result->fetch_assoc();
    if (!password_verify($currentPassword, $row['password'])) return ['error' => 'Current password is incorrect'];
    $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
    $update = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
    $update->bind_param('si', $hashed, $userId);
    $update->execute();
    if ($update->affected_rows === 0) return ['error' => 'User not found'];
    return ['success' => true, 'message' => 'Password reset successfully'];
}
?>
