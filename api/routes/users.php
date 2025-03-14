<?php
require_once('../config/database.php');

// Fonction pour récupérer tous les utilisateurs
function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
    u.utilisateur_id,
    u.utilisateur_nom,
    u.utilisateur_prenom,
    u.utilisateur_statut,
    u.utilisateur_email,
    v.ville_nom AS ville,
    p.class_name AS promotion
FROM 
    utilisateur u
JOIN 
    ville v ON u.ville_id = v.ville_id
LEFT JOIN 
    appartenir a ON u.utilisateur_id = a.utilisateur_id
LEFT JOIN 
    promotion p ON a.promotion_id = p.promotion_id;

");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
