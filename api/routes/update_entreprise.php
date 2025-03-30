<?php

require_once('../config/database.php');
require_once('../controllers/EntrepriseController.php');

$entrepriseController = new EntrepriseController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Récupérer les données JSON envoyées dans le corps de la requête
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode([
            "success" => false,
            "error" => "Données JSON invalides ou manquantes."
        ]);
        exit;
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Convertir l'ID en entier
        if ($id <= 0) {
            echo json_encode([
                "success" => false,
                "error" => "ID invalide."
            ]);
            exit;
        }

        // Appeler la méthode updateEntreprise avec l'ID et les données
        $response = $entrepriseController->updateEntreprise($id, $data);
        echo json_encode($response);
        exit; // Arrêter l'exécution après avoir envoyé la réponse
    } else {
        echo json_encode([
            "success" => false,
            "error" => "ID de l'entreprise manquant."
        ]);
        exit;
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
    exit;
}
?>