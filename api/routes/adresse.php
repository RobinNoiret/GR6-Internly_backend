<?php

require_once('../config/database.php');
require_once('../controllers/AdresseController.php');

$adresseController = new AdresseController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $adresse = $adresseController->getAdresseById($_GET['id']);
        echo json_encode($adresse);
    } else {
        $adresses = $adresseController->getAllAdresses();
        echo json_encode($adresses);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>