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
            v.ville_nom AS ville_nom,
            v.ville_code_postal AS ville_code_postal
        FROM 
            offre o
        JOIN 
            entreprise e ON o.entreprise_id = e.entreprise_id
        JOIN
            adresse a ON e.entreprise_id = a.entreprise_id
        JOIN
            ville v ON a.ville_id = v.ville_id;");
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
            v.ville_nom AS ville,
            v.ville_code_postal AS code_postal,
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
        JOIN 
            adresse a ON e.entreprise_id = a.entreprise_id  
        JOIN
            ville v ON a.ville_id = v.ville_id
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
            v.ville_nom AS ville,
            v.ville_code_postal AS code_postal,
            GROUP_CONCAT(c.competence_nom SEPARATOR ', ') AS competences
        FROM
            offre o
        JOIN
            entreprise e ON o.entreprise_id = e.entreprise_id
        JOIN
            adresse a ON e.entreprise_id = a.entreprise_id
        JOIN
            ville v ON a.ville_id = v.ville_id
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
            v.ville_nom AS ville_nom,
            v.ville_code_postal AS ville_code_postal,
            GROUP_CONCAT(c.competence_nom SEPARATOR ', ') AS competences
        FROM 
            offre o
        JOIN 
            entreprise e ON o.entreprise_id = e.entreprise_id
        JOIN
            adresse a ON e.entreprise_id = a.entreprise_id
        JOIN
            ville v ON a.ville_id = v.ville_id
        LEFT JOIN 
            competence_offre co ON o.offre_id = co.offre_id
        LEFT JOIN 
            competence c ON co.competence_id = c.competence_id
        GROUP BY 
            o.offre_id, o.offre_titre, o.offre_description, o.offre_remuneration, o.offre_date_debut, o.offre_date_fin, o.offre_places, o.offre_date_publication, e.entreprise_nom, v.ville_nom, v.ville_code_postal
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
                COUNT(wishlist.utilisateur_id) AS wishListCount
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

    public function getWishlistByUserId($userId) {
        $stmt = $this->pdo->prepare("
            SELECT 
                e.entreprise_nom,
                o.offre_titre AS offre_nom, -- Correction ici
                v.ville_nom,
                v.ville_code_postal
            FROM 
                wishlist w
            JOIN 
                offre o ON w.offre_id = o.offre_id
            JOIN 
                entreprise e ON o.entreprise_id = e.entreprise_id
            JOIN
                adresse a ON e.entreprise_id = a.entreprise_id
            JOIN
                ville v ON a.ville_id = v.ville_id
            WHERE 
                w.utilisateur_id = :userId
        ");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>