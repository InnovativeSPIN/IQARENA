<?php

include("./resource/conn.php");

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();


if (isset($_SESSION['role_id'])) {
    switch ($_SESSION['role_id']) {
        case 1: // student
            header("Location: ./student");
            exit;
        case 2: // Faculty
            header("Location: ./faculty");
            exit;
        case 3: // Hod
            header("Location: ./hod");
            exit;
        default:
            header("Location: ./main.php");
            exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['roll_no'], $_POST['password'])) {
    $roll_no = trim($_POST['roll_no']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE roll_no = ? LIMIT 1");
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);

    $_SESSION['id'] = $user['id'];
    $_SESSION['user_id'] = $user['id']; // For student report page
        $_SESSION['roll_no'] = $user['roll_no'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role_id'] = $user['role_id'];
        $_SESSION['department_id'] = $user['department_id'];
        $_SESSION['year'] = $user['year'];

        switch ($user['role_id']) {
            case 1: // student
                header("Location: ./student");
                break;
            case 2: // Faculty
                header("Location: ./faculty");
                break;
            case 3: // Hod
                header("Location: ../hod");
                break;
            default: // Unknown role
                header("Location: ../../main.php");
                break;
        }
        exit;
    } else {
        header("Location: ./");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Arena Portal - Login </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    

    <link rel="stylesheet" href="./assets/css/auth/login.css">
</head>

<body>
    <div class="w-full max-w-4xl mx-auto relative z-10 mt-10">
        <!-- Toggle Buttons -->
        <div class="flex mb-8 mt-5 rounded-full bg-white shadow-md overflow-hidden w-fit mx-auto">
             <a href="./login.php">
             <button id="loginToggle" class="toggle-btn active px-6 py-2 font-medium rounded-full transition-all duration-300">Login</button>
           </a>
            <a href="./register.php">
                <button id="registerToggle" class="toggle-btn px-6 py-2 font-medium rounded-full transition-all duration-300">Register</button>
            </a>
        </div>

        <!-- Login Form -->
        <div id="loginForm" class="form-container rounded-2xl shadow-xl p-8 animate-fade w-full max-w-md mx-auto">
            <div class="text-center mb-8 animate-fade-in">
                <h1 class="text-3xl font-bold text-[var(--primary-orange)] mb-2">Welcome Back!</h1>
            </div>
          <form action="./login.php" method="POST" class="space-y-6 group">
    <div>
        <label for="roll_no" class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
        <input type="text" name="roll_no" id="roll_no" class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
            placeholder="9210" required>
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password" class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
            placeholder="••••••••" required>
    </div>

    <div>
        <label for="user_role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
        <input type="text" id="role_name" class="input-field w-full px-4 py-3 rounded-lg focus:outline-none"
            placeholder="your role" disabled>
    </div>

    <button type="submit" class="btn-primary w-full py-3 px-4 rounded-lg text-white font-semibold shadow-md">Login</button>
</form>
        </div>

        
    </div> 


  <script>
document.getElementById("roll_no").addEventListener("blur", function () {
    const rollNo = this.value.trim();
    if (!rollNo) return;

    fetch("./backend/auth/login_role.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "roll_no=" + encodeURIComponent(rollNo)
    })
    .then(response => response.text())
    .then(data => {
        const roleField = document.getElementById("role_name");
        if (data && data !== "User not found") {
            roleField.value = data.toUpperCase(); 
        } else {
            roleField.value = "";
            alert("User not found");
        }
    })
    .catch(err => {
        console.error("Error fetching role:", err);
    });
});
</script>

</body>

</html>
