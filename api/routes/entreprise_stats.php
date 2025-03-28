<?php

require_once('../config/database.php');
require_once('../controllers/EntrepriseController.php');

$entrepriseController = new EntrepriseController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['type']) && $_GET['type'] === 'top_rated') {
        $topRatedEntreprises = $entrepriseController->getTopRatedEntreprises();
        echo json_encode($topRatedEntreprises);
    } elseif (isset($_GET['type']) && $_GET['type'] === 'count_by_domain') {
        $countByDomain = $entrepriseController->getEntrepriseCountByDomain();
        echo json_encode($countByDomain);
    } else {
        echo json_encode(["error" => "Invalid type parameter"]);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>