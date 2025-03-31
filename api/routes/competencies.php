<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $competencies = $offerController->getAllCompetencies();
    echo json_encode($competencies);
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>