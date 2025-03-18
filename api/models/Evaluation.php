<?php

class Evaluation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEvaluations() {
        $stmt = $this->pdo->query("SELECT * FROM evaluation");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEvaluationById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM evaluation WHERE evaluation_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>