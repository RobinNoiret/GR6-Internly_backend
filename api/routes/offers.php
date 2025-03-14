<?php
require_once('../config/database.php');

// Fonction pour récupérer toutes les offres
function getOffers() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
    o.offre_id,
    o.offre_titre,
    o.offre_description,
    o.offre_remuneration,
    o.offre_date_debut,
    o.offre_date_fin,
    o.offre_places,
    o.offre_date_publication,
    e.entreprise_nom AS entreprise_nom
FROM 
    offre o
JOIN 
    entreprise e ON o.entreprise_id = e.entreprise_id;
");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>