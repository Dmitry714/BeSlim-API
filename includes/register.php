<?php

include 'db.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $input = json_decode(file_get_contents("php://input"), true);

    $fullName = $input['fullName'] ?? null;
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;
    

    if ($fullName && $email && $password) {
        try {
            
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $conn->prepare("INSERT INTO Users (First_Name, Email, Password) VALUES (:fullName, :email, :password)");
            $stmt->bindParam(':fullName', $fullName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User has been added.'
                ], JSON_UNESCAPED_UNICODE);
            } else {
    
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Request failed.'
                ], JSON_UNESCAPED_UNICODE);
            }
        } catch (PDOException $e) {
     
            echo json_encode([
                'status' => 'error',
                'message' => 'An error has occurred: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    } else {
   
        echo json_encode([
            'status' => 'error',
            'message' => 'Incorrect input data'
        ], JSON_UNESCAPED_UNICODE);
    }
} else {

    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method.'
    ], JSON_UNESCAPED_UNICODE);
}
?>
