<?php

require_once('../config/database.php');
require_once('../controllers/UserController.php');

$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $user = $userController->getUserById($_GET['id']);
        echo json_encode($user);
    } elseif (isset($_GET['count']) && $_GET['count'] == 'students') {
        $count = $userController->countStudents();
        echo json_encode($count);
    } else {
        $users = $userController->getAllUsers();
        echo json_encode($users);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/api/login') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['email']) && isset($data['password'])) {
        $result = $userController->loginUser($data['email'], $data['password']);
        if ($result) {
            echo json_encode($result);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Invalid email or password"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Email and password are required"]);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>