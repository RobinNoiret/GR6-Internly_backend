<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $offer = $offerController->getOfferById($_GET['id']);
        echo json_encode($offer);
    } else {
        $offers = $offerController->getAllOffers();
        echo json_encode($offers);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>