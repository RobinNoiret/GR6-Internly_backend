<?php

require_once('../config/database.php');
require_once('../controllers/UserController.php');

$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data) {
        $response = $userController->createUser($data);
        echo json_encode($response);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "Données JSON invalides ou manquantes."
        ]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
?>