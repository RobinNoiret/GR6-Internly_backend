<?php
require_once('../config/database.php');

// Fonction pour récupérer toutes les adresses
function getAdresses() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM adresse");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>