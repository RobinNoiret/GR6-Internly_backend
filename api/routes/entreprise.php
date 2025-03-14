<?php
require_once('../config/database.php');

function getEntreprise() {
    global $pdo;
    $stmt = $pdo->query("SELECT 
    e.entreprise_id,
    e.entreprise_nom,
    e.entreprise_description,
    e.entreprise_email,
    e.entreprise_telephone,
    e.entreprise_domaine,
    e.entreprise_visibilite,
    a.adresse_rue,
    a.adresse_num_rue,
    v.ville_nom AS ville,
    v.ville_code_postal
FROM 
    entreprise e
JOIN 
    adresse a ON e.entreprise_id = a.entreprise_id
JOIN 
    ville v ON a.ville_id = v.ville_id;
");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>