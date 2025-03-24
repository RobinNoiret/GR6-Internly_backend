<?php

require_once('../models/Evaluation.php');

class EvaluationController {
    private $evaluationModel;

    public function __construct($pdo) {
        $this->evaluationModel = new Evaluation($pdo);
    }

    public function getAllEvaluations() {
        return $this->evaluationModel->getAllEvaluations();
    }

    public function getEvaluationById($id) {
        return $this->evaluationModel->getEvaluationById($id);
    }
}
?>