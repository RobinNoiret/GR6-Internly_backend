<?php

require_once('../config/database.php');
require_once('../controllers/CandidatureController.php');

$candidatureController = new CandidatureController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si le fichier est bien reçu
    if (!isset($_FILES['cv']) || $_FILES['cv']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            "success" => false,
            "error" => "Fichier non reçu ou erreur lors du téléchargement. Code : " . ($_FILES['cv']['error'] ?? 'non défini')
        ]);
        exit;
    }

    $data = $_POST; // Récupérer les données du formulaire
    $cvFile = $_FILES['cv']; // Récupérer le fichier CV

    $response = $candidatureController->createCandidature($data, $cvFile);
    echo json_encode($response);
    exit;
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
?>