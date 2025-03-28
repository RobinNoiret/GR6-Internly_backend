<?php

require_once('../config/database.php');
require_once('../controllers/CandidatureController.php');

$candidatureController = new CandidatureController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['user_id']) && isset($_GET['count']) && $_GET['count'] == 'status') {
        // Récupérer le nombre de candidatures par statut pour un utilisateur spécifique
        $userId = intval($_GET['user_id']);
        $counts = $candidatureController->getCandidatureCountByStatusForUser($userId);
        echo json_encode($counts);
    } elseif (isset($_GET['user_id'])) {
        $userId = intval($_GET['user_id']);
        $candidatures = $candidatureController->getCandidaturesByUserId($userId);
        echo json_encode($candidatures);
    } elseif (isset($_GET['id'])) {
        $candidature = $candidatureController->getCandidatureById($_GET['id']);
        echo json_encode($candidature);
    } else {
        $candidatures = $candidatureController->getAllCandidatures();
        echo json_encode($candidatures);
    }
}
?>