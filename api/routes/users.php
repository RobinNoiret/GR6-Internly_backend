<?php
require_once('../config/database.php');

// Fonction pour récupérer tous les utilisateurs
function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM utilisateur");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
