<?php

require_once('../config/database.php');
require_once('../controllers/CandidatureController.php');

$candidatureController = new CandidatureController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $candidatures = $candidatureController->getCandidaturesWithDetails();
    echo json_encode($candidatures);
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>