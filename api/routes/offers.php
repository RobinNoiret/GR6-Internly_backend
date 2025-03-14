<?php
require_once('../config/database.php');

// Fonction pour récupérer toutes les offres
function getOffers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM offres");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>