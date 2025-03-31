<?php

require_once('../config/database.php');
require_once('../controllers/UserController.php');

$userController = new UserController($pdo);

// Extraire l'ID de l'URL si le chemin correspond à /api/user/{id}
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($requestUri[2]) && $requestUri[1] === 'user') {
    $userId = intval($requestUri[2]); // Récupérer l'ID de l'utilisateur
    $userDetails = $userController->getUserDetailsById($userId);
    if ($userDetails) {
        echo json_encode($userDetails);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "User not found"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['field']) && $_GET['field'] === 'prenom' && isset($_GET['id'])) {
        // Récupérer le prénom de l'utilisateur via son ID
        $userId = intval($_GET['id']);
        $userFirstName = $userController->getUserFirstNameById($userId);
        if ($userFirstName) {
            echo json_encode($userFirstName);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "User not found"]);
        }
    } elseif (isset($_GET['status'])) {
        $status = $_GET['status'];
        $usersByStatus = $userController->getUsersByStatus($status);
        if ($usersByStatus) {
            echo json_encode($usersByStatus);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "No users found with the specified status"]);
        }
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