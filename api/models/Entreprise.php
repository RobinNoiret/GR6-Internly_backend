<?php

class Entreprise {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEntreprises() {
        $stmt = $this->pdo->query("SELECT * FROM entreprise");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEntrepriseById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM entreprise WHERE entreprise_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>