<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed. Use POST."
    ]);
    exit();
}

// Support both standard POST data and JSON raw input
$input = json_decode(file_get_contents("php://input"), true);
$username = isset($input['username']) ? $input['username'] : (isset($_POST['username']) ? $_POST['username'] : '');
$password = isset($input['password']) ? $input['password'] : (isset($_POST['password']) ? $_POST['password'] : '');

if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Username and password are required fields."
    ]);
    exit();
}

$username = mysqli_real_escape_string($conn, $username);
$query = mysqli_query($conn, "
    SELECT users.*, roles.role_name
    FROM users
    LEFT JOIN roles ON users.role_id = roles.id
    WHERE username='$username'
");

if (mysqli_num_rows($query) === 1) {
    $user = mysqli_fetch_assoc($query);
    if (password_verify($password, $user['password'])) {
        
        // Email verification check bypassed for API access

        echo json_encode([
            "success" => true,
            "message" => "Authentication successful.",
            "data" => [
                "id" => (int)$user['id'],
                "username" => $user['username'],
                "email" => $user['email'],
                "role" => $user['role_name'],
                "created_at" => $user['created_at']
            ]
        ], JSON_PRETTY_PRINT);
    } else {
        http_response_code(401);
        echo json_encode([
            "success" => false,
            "message" => "Invalid password."
        ]);
    }
} else {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Username not found."
    ]);
}
?>
