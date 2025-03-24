<?php

class Candidature {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCandidatures() {
        $stmt = $this->pdo->query("SELECT * FROM candidature");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCandidatureById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM candidature WHERE candidature_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>