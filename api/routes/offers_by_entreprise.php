<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['entreprise_id'])) {
        $entrepriseId = intval($_GET['entreprise_id']);
        $offers = $offerController->getOffersByEntrepriseId($entrepriseId);
        echo json_encode($offers);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Entreprise ID is required"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
?>