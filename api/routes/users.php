<?php
require_once('../config/database.php');

// Fonction pour récupérer tous les utilisateurs
function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
    u.user_id,
    u.user_nom,
    u.user_prenom,
    u.user_statut,
    u.user_email,
    v.ville_nom AS ville,
    p.class_name AS promotion
FROM 
    utilisateur u
JOIN 
    ville v ON u.ville_id = v.ville_id
LEFT JOIN 
    appartenir a ON u.user_id = a.user_id
LEFT JOIN 
    promotion p ON a.promo_id = p.promo_id;

");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
