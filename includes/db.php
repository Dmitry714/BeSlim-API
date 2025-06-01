<?php

header("Content-Type: application/json");

$host = 'localhost';

$dbname = 'f1077573_beslim';
$username = 'f1077573_beslim';
$password = 'CA4V6jVxFAie48G';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($conn) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Connection completed successfully.'
        ], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Connection error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
