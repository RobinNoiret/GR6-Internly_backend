<?php
require_once('../config/database.php');

// Fonction pour récupérer toutes les adresses
function getCandidatures() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
    c.offre_id,
    c.user_id,
    c.candidature_lm,
    c.candidature_status,
    c.candidature_cv,
    c.candidature_date,
    u.user_nom AS utilisateur_nom,
    u.user_prenom AS utilisateur_prenom,
    u.user_email AS utilisateur_email,
    o.offre_titre AS offre_titre,
    e.entreprise_nom AS entreprise_nom
FROM 
    candidatures c
JOIN 
    utilisateur u ON c.user_id = u.user_id
JOIN 
    offres o ON c.offre_id = o.offre_id
JOIN 
    entreprise e ON o.entreprise_id = e.entreprise_id;
");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


