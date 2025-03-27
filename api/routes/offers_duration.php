<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $durations = $offerController->getOffersByDuration();
    echo json_encode($durations);
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>