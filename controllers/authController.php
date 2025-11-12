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

function signup($rollNo, $password, $email) {
    global $conn;
    $sql = "SELECT password, email FROM users WHERE roll_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $rollNo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) return ['error' => 'User not found'];
    $row = $result->fetch_assoc();
    if (!empty($row['password'])) return ['error' => 'Password already set for this user'];
    $emailUpdated = false;
    if (empty($row['email']) && $email) {
        $updateEmail = $conn->prepare("UPDATE users SET email = ? WHERE roll_no = ?");
        $updateEmail->bind_param('ss', $email, $rollNo);
        $updateEmail->execute();
        $emailUpdated = true;
    }
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE roll_no = ?");
    $update->bind_param('ss', $hashed, $rollNo);
    $update->execute();
    $message = 'Password set successfully.';
    if ($emailUpdated) {
        $message .= ' Email updated.';
    }
    $stmt2 = $conn->prepare("SELECT roll_no, email FROM users WHERE roll_no = ?");
    $stmt2->bind_param('s', $rollNo);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $user = $result2->fetch_assoc();
    return ['success' => true, 'message' => $message, 'user' => $user];
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
  
    $key = 'nscet123'; 
    $payload = [
        'id' => $user['id'],
        'roll_no' => $user['roll_no'],
        'role' => $user['role_name'],
        'exp' => time() + 60*60*24 
    ];
    $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
    $payload_enc = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payload_enc", $key, true);
    $signature_enc = base64_encode($signature);
    $token = "$header.$payload_enc.$signature_enc";

    return ['success' => true, 'user' => $user, 'token' => $token];
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
