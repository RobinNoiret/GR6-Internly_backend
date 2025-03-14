<?php
require_once('../config/database.php');

// Fonction pour récupérer toutes les adresses
function getEvaluations() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
    ev.entreprise_id,
    ev.user_id,
    ev.evaluation_note,
    e.entreprise_nom AS entreprise_nom,
    u.user_nom AS utilisateur_nom,
    u.user_prenom AS utilisateur_prenom
FROM 
    evaluations ev
JOIN 
    entreprise e ON ev.entreprise_id = e.entreprise_id
JOIN 
    utilisateur u ON ev.user_id = u.user_id;");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>