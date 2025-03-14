<?php
require_once('../config/database.php');

// Fonction pour récupérer toutes les adresses
function getEvaluations() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
    ev.entreprise_id,
    ev.utilisateur_id,
    ev.evaluation_note,
    e.entreprise_nom AS entreprise_nom,
    u.utilisateur_nom AS utilisateur_nom,
    u.utilisateur_prenom AS utilisateur_prenom
FROM 
    evaluations ev
JOIN 
    entreprise e ON ev.entreprise_id = e.entreprise_id
JOIN 
    utilisateur u ON ev.utilisateur_id = u.utilisateur_id;");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>