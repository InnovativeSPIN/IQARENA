<?php
    include_once(dirname(__DIR__) . '/config/cors.php');
    include_once(dirname(__DIR__) . '/controllers/authController.php');

    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

   
    if ($method === 'GET' && preg_match('/\/user\/([\w-]+)/', $uri, $matches)) {
        $rollNo = $matches[1];
        $user = getUserByRollNo($rollNo);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
        exit;
    }

    if ($method === 'POST' && strpos($uri, '/signup') !== false) {
            $data = json_decode(file_get_contents('php://input'), true);
            $rollNo = $data['rollNo'] ?? '';
            $password = $data['password'] ?? '';
            $email = $data['email'] ?? null;
            $result = signup($rollNo, $password, $email);
            if (isset($result['error'])) {
                http_response_code(400);
            }
            echo json_encode($result);
            exit;
        }

    if ($method === 'POST' && strpos($uri, '/login') !== false) {
        $data = json_decode(file_get_contents('php://input'), true);
        $rollNo = $data['rollNo'] ?? '';
        $password = $data['password'] ?? '';
        $result = login($rollNo, $password);
        if (isset($result['error'])) {
            http_response_code(401);
        }
        echo json_encode($result);
        exit;
    }

    if ($method === 'PUT' && strpos($uri, '/profile') !== false) {
        // Auth middleware stub: $userId from token/session
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = $data['user_id'] ?? 0;
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $result = updateProfile($userId, $name, $email);
        if (isset($result['error'])) {
            http_response_code(400);
        }
        echo json_encode($result);
        exit;
    }

    if ($method === 'PUT' && strpos($uri, '/reset-password') !== false) {
        // Auth middleware stub: $userId from token/session
        $data = json_decode(file_get_contents('php://input'), true);
        $userId = $data['user_id'] ?? 0;
        $currentPassword = $data['currentPassword'] ?? '';
        $newPassword = $data['newPassword'] ?? '';
        $result = resetPassword($userId, $currentPassword, $newPassword);
        if (isset($result['error'])) {
            http_response_code(400);
        }
        echo json_encode($result);
        exit;
    }

    // If no route matched
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
