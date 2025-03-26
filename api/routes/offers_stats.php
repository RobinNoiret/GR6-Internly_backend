<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stats = $offerController->getWishlistStatistics();
    echo json_encode($stats);
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>