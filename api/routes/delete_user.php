<?php

require_once('../config/database.php');
require_once('../controllers/UserController.php');

$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Décoder les données JSON envoyées dans le corps de la requête
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $id = intval($data['id']);
        $response = $userController->deleteUser($id);
        echo json_encode($response);
        exit;
    } else {
        echo json_encode([
            "success" => false,
            "error" => "ID de l'utilisateur manquant."
        ]);
        exit;
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
?>