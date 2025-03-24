<?php

require_once('../config/database.php');
require_once('../controllers/EvaluationController.php');

$evaluationController = new EvaluationController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $evaluation = $evaluationController->getEvaluationById($_GET['id']);
        echo json_encode($evaluation);
    } else {
        $evaluations = $evaluationController->getAllEvaluations();
        echo json_encode($evaluations);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>