<?php

require_once('../config/database.php');
require_once('../controllers/EntrepriseController.php');

$entrepriseController = new EntrepriseController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);

    if (isset($data['id'])) {
        $response = $entrepriseController->deleteEntreprise($data['id']);
        echo json_encode($response);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "ID de l'entreprise manquant."
        ]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
?>