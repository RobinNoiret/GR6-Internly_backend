<?php

class Offer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllOffers() {
        $stmt = $this->pdo->query("SELECT 
            o.offre_id,
            o.offre_titre,
            o.offre_description,
            o.offre_remuneration,
            o.offre_date_debut,
            o.offre_date_fin,
            o.offre_places,
            o.offre_date_publication,
            e.entreprise_id as entreprise_id,
            e.entreprise_nom AS entreprise_nom,
        FROM 
            offre o
        JOIN 
            entreprise e ON o.entreprise_id = e.entreprise_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOfferById($id) {
        $stmt = $this->pdo->prepare("SELECT 
            o.offre_id,
            o.offre_titre,
            o.offre_description,
            o.offre_remuneration,
            o.offre_date_debut,
            o.offre_date_fin,
            o.offre_places,
            o.offre_date_publication,
            o.niveau_etude_minimal as offre_niveau_etude_minimal,
            o.experience_requise as offre_experience_requise,
            e.entreprise_domaine AS entreprise_domaine,
            e.entreprise_nom AS entreprise_nom,
            e.entreprise_id AS entreprise_id,
            GROUP_CONCAT(c.competence_nom SEPARATOR ', ') AS competences
        FROM 
            offre o
        JOIN 
            entreprise e ON o.entreprise_id = e.entreprise_id
        LEFT JOIN 
            competence_offre co ON o.offre_id = co.offre_id
        LEFT JOIN 
            competence c ON co.competence_id = c.competence_id
        WHERE 
            o.offre_id = :id
        GROUP BY 
            o.offre_id, o.offre_titre, e.entreprise_nom, e.entreprise_id;");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOffersWithCompetencies() {
        $stmt = $this->pdo->query("SELECT
            o.offre_id,
            o.offre_titre AS titre_offre,
            e.entreprise_nom AS entreprise,
            GROUP_CONCAT(c.competence_nom SEPARATOR ', ') AS competences
        FROM
            offre o
        JOIN
            entreprise e ON o.entreprise_id = e.entreprise_id
        LEFT JOIN
            competence_offre co ON o.offre_id = co.offre_id
        LEFT JOIN
            competence c ON co.competence_id = c.competence_id
        GROUP BY
            o.offre_id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countOffers() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS offer_count FROM offre");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRecentOffers() {
        $stmt = $this->pdo->query("SELECT 
            o.offre_id,
            o.offre_titre,
            o.offre_description,
            o.offre_remuneration,
            o.offre_date_debut,
            o.offre_date_fin,
            o.offre_places,
            o.offre_date_publication,
            e.entreprise_nom AS entreprise_nom,
            GROUP_CONCAT(c.competence_nom SEPARATOR ', ') AS competences
        FROM 
            offre o
        JOIN 
            entreprise e ON o.entreprise_id = e.entreprise_id
        LEFT JOIN 
            competence_offre co ON o.offre_id = co.offre_id
        LEFT JOIN 
            competence c ON co.competence_id = c.competence_id
        GROUP BY 
            o.offre_id, o.offre_titre, o.offre_description, o.offre_remuneration, o.offre_date_debut, o.offre_date_fin, o.offre_places, o.offre_date_publication, e.entreprise_nom
        ORDER BY 
            o.offre_date_publication DESC
        LIMIT 6");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWishlistStatistics() {
        $stmt = $this->pdo->query("
            SELECT
                offre.offre_id,
                offre.offre_titre,
                COUNT(DISTINCT wishlist.utilisateur_id) AS wishListCount
            FROM
                offre
            LEFT JOIN
                wishlist ON offre.offre_id = wishlist.offre_id
            LEFT JOIN
                competence_offre ON offre.offre_id = competence_offre.offre_id
            LEFT JOIN
                competence ON competence_offre.competence_id = competence.competence_id
            GROUP BY
                offre.offre_id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOffersByDuration() {
        $stmt = $this->pdo->query("
            SELECT
                CASE
                    WHEN TIMESTAMPDIFF(MONTH, offre_date_debut, offre_date_fin) BETWEEN 0 AND 6 THEN '0 à 6 mois'
                    WHEN TIMESTAMPDIFF(MONTH, offre_date_debut, offre_date_fin) BETWEEN 7 AND 12 THEN '6 à 12 mois'
                    ELSE '+ de 12 mois'
                END AS duree_groupe,
                COUNT(*) AS nombre_offres
            FROM
                offre
            GROUP BY
                duree_groupe
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCompetencies() {
        $stmt = $this->pdo->query("SELECT * FROM competence");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWishlistByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT 
                o.offre_id,
                e.entreprise_nom,
                o.offre_titre AS offre_nom
            FROM 
                wishlist w
            JOIN 
                offre o ON w.offre_id = o.offre_id
            JOIN 
                entreprise e ON o.entreprise_id = e.entreprise_id
            WHERE 
                w.utilisateur_id = :userId
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOffer($titre, $description, $remuneration, $dateDebut, $dateFin, $places, $entrepriseId, $experienceRequise, $niveauEtudeMinimal, $competences) {
        try {
            // Convertir entrepriseId en entier
            $entrepriseId = (int) $entrepriseId;
    
            // Insérer l'offre
            $stmt = $this->pdo->prepare("
                INSERT INTO offre (offre_titre, offre_description, offre_remuneration, offre_date_debut, offre_date_fin, offre_places, entreprise_id, experience_requise, niveau_etude_minimal)
                VALUES (:titre, :description, :remuneration, :dateDebut, :dateFin, :places, :entrepriseId, :experienceRequise, :niveauEtudeMinimal)
            ");
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':remuneration' => $remuneration,
                ':dateDebut' => $dateDebut,
                ':dateFin' => $dateFin,
                ':places' => $places,
                ':entrepriseId' => $entrepriseId, // Utilisation correcte de l'ID ici
                ':experienceRequise' => $experienceRequise,
                ':niveauEtudeMinimal' => $niveauEtudeMinimal
            ]);
    
            // Récupérer l'ID de l'offre nouvellement créée
            $offreId = $this->pdo->lastInsertId();
    
            // Associer les compétences à l'offre
            if (!empty($competences)) {
                $stmtCompetences = $this->pdo->prepare("
                    INSERT INTO competence_offre (offre_id, competence_id)
                    SELECT :offreId, competence_id FROM competence WHERE competence_nom = :competenceNom
                ");
                foreach ($competences as $competence) {
                    $stmtCompetences->execute([
                        ':offreId' => $offreId,
                        ':competenceNom' => $competence
                    ]);
                }
            }
    
            return ["success" => true, "offre_id" => $offreId];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public function updateOffer($id, $titre, $description, $remuneration, $dateDebut, $dateFin, $places, $experienceRequise, $niveauEtudeMinimal, $competences) {
        try {
            // Mettre à jour les informations de l'offre
            $stmt = $this->pdo->prepare("
                UPDATE offre
                SET 
                    offre_titre = :titre,
                    offre_description = :description,
                    offre_remuneration = :remuneration,
                    offre_date_debut = :dateDebut,
                    offre_date_fin = :dateFin,
                    offre_places = :places,
                    experience_requise = :experienceRequise,
                    niveau_etude_minimal = :niveauEtudeMinimal
                WHERE offre_id = :id
            ");
            $stmt->execute([
                ':titre' => $titre,
                ':description' => $description,
                ':remuneration' => $remuneration,
                ':dateDebut' => $dateDebut,
                ':dateFin' => $dateFin,
                ':places' => $places,
                ':experienceRequise' => $experienceRequise,
                ':niveauEtudeMinimal' => $niveauEtudeMinimal,
                ':id' => $id
            ]);

            // Supprimer les associations de compétences existantes
            $stmtDelete = $this->pdo->prepare("DELETE FROM competence_offre WHERE offre_id = :id");
            $stmtDelete->execute([':id' => $id]);

            // Normaliser le champ competences
            if (is_string($competences)) {
                $competences = [$competences]; // Convertir en tableau si c'est une chaîne
            }

            // Insérer les nouvelles compétences associées
            if (!empty($competences) && is_array($competences)) {
                $stmtInsert = $this->pdo->prepare("
                    INSERT INTO competence_offre (offre_id, competence_id)
                    SELECT :id, competence_id FROM competence WHERE competence_nom = :competenceNom
                ");
                foreach ($competences as $competence) {
                    $stmtInsert->execute([
                        ':id' => $id,
                        ':competenceNom' => $competence
                    ]);
                }
            }

            return ["success" => true, "message" => "Offre mise à jour avec succès."];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }

    public function deleteOffer($offreId) {
        try {
            // Supprimer les associations de compétences
            $stmtCompetences = $this->pdo->prepare("DELETE FROM competence_offre WHERE offre_id = :offreId");
            $stmtCompetences->execute([':offreId' => $offreId]);
    
            // Supprimer l'offre
            $stmtOffer = $this->pdo->prepare("DELETE FROM offre WHERE offre_id = :offreId");
            $stmtOffer->execute([':offreId' => $offreId]);
    
            return ["success" => true, "message" => "Offre supprimée avec succès."];
        } catch (PDOException $e) {
            return ["success" => false, "error" => $e->getMessage()];
        }
    }
    
}
?>