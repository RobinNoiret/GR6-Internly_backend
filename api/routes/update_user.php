<?php

require_once('../config/database.php');
require_once('../controllers/UserController.php');

$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Décoder les données JSON envoyées dans le corps de la requête
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode([
            "success" => false,
            "error" => "Données JSON invalides ou manquantes."
        ]);
        exit;
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $response = $userController->updateUser($id, $data);
        echo json_encode($response);
        exit;
    } else {
        echo json_encode([
            "success" => false,
            "error" => "ID de l'utilisateur manquant."
        ]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
?>