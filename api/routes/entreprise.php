<?php

require_once('../config/database.php');
require_once('../controllers/EntrepriseController.php');

$entrepriseController = new EntrepriseController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $entreprise = $entrepriseController->getEntrepriseById($_GET['id']);
        echo json_encode($entreprise);
    } else {
        $entreprises = $entrepriseController->getAllEntreprises();
        echo json_encode($entreprises);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>