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

    public function countEntreprises() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS entreprise_count FROM entreprise");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTopRatedEntreprises() {
        $stmt = $this->pdo->query("
            SELECT
                e.entreprise_id,
                e.entreprise_nom,
                AVG(ev.evaluation_note) AS moyenne_note
            FROM
                entreprise e
            JOIN
                evaluations ev ON e.entreprise_id = ev.entreprise_id
            GROUP BY
                e.entreprise_id, e.entreprise_nom
            ORDER BY
                moyenne_note DESC
            LIMIT 10
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getEntrepriseCountByDomain() {
        $stmt = $this->pdo->query("
            SELECT
                entreprise_domaine,
                COUNT(*) AS nombre_entreprises
            FROM
                entreprise
            GROUP BY
                entreprise_domaine
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>