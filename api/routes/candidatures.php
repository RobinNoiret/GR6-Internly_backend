<?php

require_once('../config/database.php');
require_once('../controllers/CandidatureController.php');

$candidatureController = new CandidatureController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $candidature = $candidatureController->getCandidatureById($_GET['id']);
        echo json_encode($candidature);
    } else {
        $candidatures = $candidatureController->getAllCandidatures();
        echo json_encode($candidatures);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>