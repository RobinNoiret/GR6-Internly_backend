<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Vérifiez la clé 'offre_id' au lieu de 'id'
    if (isset($data['offre_id'])) {
        $offreId = intval($data['offre_id']); // Utilisez 'offre_id'
        $response = $offerController->deleteOffer($offreId);
        echo json_encode($response);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "ID de l'offre manquant."
        ]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
?>