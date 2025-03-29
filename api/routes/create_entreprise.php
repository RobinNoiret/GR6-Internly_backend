<?php

require_once('../config/database.php');
require_once('../controllers/EntrepriseController.php');

$entrepriseController = new EntrepriseController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (
        isset($data['nom']) &&
        isset($data['description']) &&
        isset($data['email']) &&
        isset($data['telephone']) &&
        isset($data['domaine']) &&
        isset($data['visibilite'])
    ) {
        try {
            $newEntrepriseId = $entrepriseController->createEntreprise($data);
            echo json_encode(["success" => true, "id" => $newEntrepriseId]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Paramètres manquants"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée"]);
}
?>