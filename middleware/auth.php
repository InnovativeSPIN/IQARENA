<?php
/**
 * Authentication Middleware
 * Validates JWT token from Authorization header
 * Returns decoded user payload or throws error
 */

function verifyToken()
{
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';

    if (!$authHeader || !preg_match('/^Bearer\s+(.*)$/i', $authHeader, $matches)) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized: No token provided.']);
        exit;
    }

    $token = $matches[1];
    $key = 'nscet123'; // Must match login key

    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token format.']);
        exit;
    }

    list($header, $payload, $signature) = $parts;

    // Decode
    $header = json_decode(base64_decode($header), true);
    $payload = json_decode(base64_decode($payload), true);
    $signatureProvided = base64_decode($signature);

    if (!$header || !$payload) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token data.']);
        exit;
    }

    // Verify signature
    $expectedSignature = hash_hmac('sha256', "$header.$payload", $key, true);
    if (!hash_equals($expectedSignature, $signatureProvided)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token signature.']);
        exit;
    }

    // Check expiration
    if (isset($payload['exp']) && $payload['exp'] < time()) {
        http_response_code(401);
        echo json_encode(['error' => 'Token has expired.']);
        exit;
    }

    return $payload; // Contains: id, roll_no, role_name, exp
}

// Optional: Role-based access control
function requireRole($requiredRole)
{
    $user = verifyToken();
    if ($user['role_name'] !== $requiredRole) {
        http_response_code(403);
        echo json_encode(['error' => "Access denied. Requires role: $requiredRole"]);
        exit;
    }
    return $user;
}

// Optional: Admin only
function requireAdmin()
{
    return requireRole('Admin');
}

// Optional: HOD only
function requireHOD()
{
    return requireRole('HOD');
}

// Optional: Faculty only
function requireFaculty()
{
    return requireRole('Faculty');
}

// Optional: Student only
function requireStudent()
{
    return requireRole('Student');
}