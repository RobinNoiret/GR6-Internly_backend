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

    public function getCandidaturesWithDetails() {
        $stmt = $this->pdo->query("SELECT 
            o.offre_titre AS titre,
            e.entreprise_nom AS entreprise_nom,
            c.candidature_date AS date,
            u.utilisateur_nom AS utilisateur_nom,
            u.utilisateur_prenom AS utilisateur_prenom
        FROM 
            candidature c
        JOIN 
            offre o ON c.offre_id = o.offre_id
        JOIN 
            entreprise e ON o.entreprise_id = e.entreprise_id
        JOIN 
            utilisateur u ON c.utilisateur_id = u.utilisateur_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCandidaturesByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT 
                o.offre_titre,
                e.entreprise_nom,
                c.candidature_date,
                c.candidature_status,
                c.candidature_lm
            FROM 
                candidature c
            JOIN 
                offre o ON c.offre_id = o.offre_id
            JOIN 
                entreprise e ON o.entreprise_id = e.entreprise_id
            WHERE 
                c.utilisateur_id = :userId
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCandidatureCountByStatusForUser($userId) {
        $stmt = $this->pdo->prepare("
            SELECT 
                candidature_status,
                COUNT(*) AS count
            FROM 
                candidature
            WHERE 
                utilisateur_id = :userId
            GROUP BY 
                candidature_status
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCandidature($offreId, $utilisateurId, $lettreMotivation, $cvPath) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO candidature (offre_id, utilisateur_id, candidature_lm, candidature_status, candidature_cv)
                VALUES (:offreId, :utilisateurId, :lettreMotivation, 'en_attente', :cvPath)
            ");
            $stmt->execute([
                ':offreId' => $offreId,
                ':utilisateurId' => $utilisateurId,
                ':lettreMotivation' => $lettreMotivation,
                ':cvPath' => $cvPath
            ]);
            return ["success" => true, "message" => "Candidature créée avec succès."];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
}
?>