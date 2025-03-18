<?php

class Adresse {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllAdresses() {
        $stmt = $this->pdo->query("SELECT * FROM adresse");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdresseById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM adresse WHERE adresse_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>