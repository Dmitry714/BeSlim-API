<?php

include("db.php");

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    $email = $input["email"] ?? null;
    $password = $input["password"] ?? null;

    if ($email && $password) {
        try {
            $stmt = $conn->prepare("SELECT ID_User, Password FROM Users WHERE Email = :email");
            $stmt->bindParam(":email", $email);

            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['Password'])) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user_id' => $user['ID_User']
                ], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Incorrect email or password'
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'An error has occurred: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Incorrect data.'
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ], JSON_UNESCAPED_UNICODE);
}
