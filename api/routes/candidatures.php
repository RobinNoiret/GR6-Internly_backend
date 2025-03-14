<?php
require_once('../config/database.php');

// Fonction pour récupérer toutes les adresses
function getCandidatures() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
        u.user_nom AS utilisateur_nom,
        u.user_prenom AS utilisateur_prenom,
        c.candidature_lm AS candidature_lm,
        c.candidature_status AS candidature_status,
        c.candidature_cv AS candidature_cv,
        e.entreprise_nom AS entreprise_nom
    FROM 
        candidatures c
    JOIN 
        utilisateur u ON c.user_id = u.user_id
    JOIN 
        offres o ON c.offre_id = o.offre_id
    JOIN 
        entreprise e ON o.entreprise_id = e.entreprise_id;");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


