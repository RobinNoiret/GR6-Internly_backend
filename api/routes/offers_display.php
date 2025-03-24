<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $offers = $offerController->getOffersWithCompetencies();
    echo json_encode($offers);
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>