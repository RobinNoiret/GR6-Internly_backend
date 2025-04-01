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
        $stmt = $this->pdo->prepare("
            SELECT
                e.*,
                AVG(ev.evaluation_note) AS Note,
                COUNT(c.utilisateur_id) AS Nombre_de_stagiaires_pris
            FROM
                entreprise e
            LEFT JOIN
                evaluations ev ON e.entreprise_id = ev.entreprise_id
            LEFT JOIN
                offre o ON e.entreprise_id = o.entreprise_id
            LEFT JOIN
                candidature c ON o.offre_id = c.offre_id AND c.candidature_status = 'acceptée'
            WHERE
                e.entreprise_id = :id
            GROUP BY
                e.entreprise_id
        ");
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

    public function createEntreprise($nom, $description, $email, $telephone, $domaine, $visibilite) {
        $stmt = $this->pdo->prepare("
            INSERT INTO entreprise (entreprise_nom, entreprise_description, entreprise_email, entreprise_telephone, entreprise_domaine, entreprise_visibilite)
            VALUES (:nom, :description, :email, :telephone, :domaine, :visibilite)
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':description' => $description,
            ':email' => $email,
            ':telephone' => $telephone,
            ':domaine' => $domaine,
            ':visibilite' => $visibilite
        ]);
        return $this->pdo->lastInsertId();
    }

    public function deleteEntreprise($id) {
        try {
            // Préparer et exécuter la requête de suppression
            $stmt = $this->pdo->prepare("DELETE FROM entreprise WHERE entreprise_id = :id");
            $stmt->execute([':id' => $id]);
            $rowCount = $stmt->rowCount(); // Nombre de lignes affectées
    
            // Vérifier si une ligne a été supprimée
            if ($rowCount === 0) {
                throw new Exception("Aucune entreprise trouvée avec cet ID.");
            }
    
            return $rowCount;
        } catch (PDOException $e) {
            // Vérifier si l'erreur est liée à une contrainte de clé étrangère
            if ($e->getCode() === '23000') { // Code SQL pour violation de contrainte
                throw new Exception("Impossible de supprimer l'entreprise car elle est liée à des offres.");
            } else {
                throw new Exception("Erreur lors de la suppression : " . $e->getMessage());
            }
        }
    }

    public function updateEntreprise($id, $nom, $description, $email, $telephone, $domaine, $visibilite) {
        try {
            // Préparer et exécuter la requête de mise à jour
            $stmt = $this->pdo->prepare("
                UPDATE entreprise
                SET 
                    entreprise_nom = :nom,
                    entreprise_description = :description,
                    entreprise_email = :email,
                    entreprise_telephone = :telephone,
                    entreprise_domaine = :domaine,
                    entreprise_visibilite = :visibilite
                WHERE entreprise_id = :id
            ");
            $stmt->execute([
                ':id' => $id,
                ':nom' => $nom,
                ':description' => $description,
                ':email' => $email,
                ':telephone' => $telephone,
                ':domaine' => $domaine,
                ':visibilite' => $visibilite
            ]);
    
            // Vérifier si une ligne a été mise à jour
            if ($stmt->rowCount() === 0) {
                throw new Exception("Aucune entreprise trouvée avec cet ID ou aucune modification effectuée.");
            }
    
            return $stmt->rowCount(); // Retourne le nombre de lignes affectées
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour : " . $e->getMessage());
        }
    }

    public function addEvaluation($entrepriseId, $utilisateurId, $evaluationNote) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO evaluations (entreprise_id, utilisateur_id, evaluation_note)
                VALUES (:entreprise_id, :utilisateur_id, :evaluation_note)
            ");
            $stmt->execute([
                ':entreprise_id' => $entrepriseId,
                ':utilisateur_id' => $utilisateurId,
                ':evaluation_note' => $evaluationNote
            ]);
            return ["success" => true, "message" => "Évaluation ajoutée avec succès."];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
}
?>