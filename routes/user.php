<?php
session_start();
require_once '../controllers/UserController.php';
require_once '../middleware/auth.php';

header('Content-Type: application/json');

$controller = new UserController();
$method = $_SERVER['REQUEST_METHOD'];
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$parts = explode('/', $uri);

// Remove 'api/user' prefix
$parts = array_slice($parts, 2);

if (empty($parts[0])) {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
    exit;
}

$action = $parts[0];
$id = $parts[1] ?? null;
$sub = $parts[2] ?? null;

// === STUDENT ROUTES ===
if ($action === 'students') {
    if ($method === 'GET') $controller->getStudents();
    elseif ($method === 'POST' && $id === 'upload') $controller->uploadStudents();
    elseif ($method === 'POST') $controller->addStudent();
    elseif ($method === 'DELETE' && $id) $controller->deleteStudent($id);
    elseif ($method === 'PUT' && $id) $controller->updateStudent($id);
    elseif ($method === 'POST' && $id && $sub === 'reset-password') $controller->resetStudentPassword($id);
}

// === FACULTY ROUTES ===
elseif ($action === 'faculty') {
    if ($method === 'GET') $controller->getFaculty();
    elseif ($method === 'POST') $controller->addStaff();
    elseif ($method === 'DELETE' && $id) $controller->deleteFaculty($id);
    elseif ($method === 'PUT' && $id) $controller->updateFaculty($id);
    elseif ($method === 'POST' && $id && $sub === 'reset-password') $controller->resetFacultyPassword($id);
}

// === DASHBOARD & PROFILE ===
elseif ($action === 'dashboard' && $method === 'GET') $controller->getStudentDashboardStats();
elseif ($action === 'profile' && $method === 'GET') $controller->getProfile();
elseif ($action === 'admin' && $method === 'PUT' && $id === 'reset-password') $controller->adminResetPassword();

// === HOD ROUTES ===
elseif ($action === 'hod') {
    if ($method === 'GET' && $id === 'staff') $controller->getDepartmentStaff();
    elseif ($method === 'GET' && $id === 'staff' && $sub) $controller->getStaffDetails($sub);
    elseif ($method === 'PUT' && $id === 'staff' && $sub) $controller->updateDepartmentStaff($sub);
    elseif ($method === 'DELETE' && $id === 'staff' && $sub) $controller->deleteDepartmentStaff($sub);
    elseif ($method === 'POST' && $id === 'staff') $controller->addDepartmentStaff();
    elseif ($method === 'POST' && $id === 'staff' && $sub && $parts[3] === 'reset-password') $controller->resetDepartmentStaffPassword($sub);

    elseif ($method === 'GET' && $id === 'students') $controller->getDepartmentStudents();
    elseif ($method === 'GET' && $id === 'students' && $sub) $controller->getStudentDetails($sub);
    elseif ($method === 'POST' && $id === 'students') $controller->addDepartmentStudent();
    elseif ($method === 'PUT' && $id === 'students' && $sub) $controller->updateDepartmentStudent($sub);
    elseif ($method === 'DELETE' && $id === 'students' && $sub) $controller->deleteDepartmentStudent($sub);
    elseif ($method === 'POST' && $id === 'students' && $sub && $parts[3] === 'reset-password') $controller->resetDepartmentStudentPassword($sub);
}

else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}