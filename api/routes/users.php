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
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>