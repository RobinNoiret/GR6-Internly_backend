<?php
$host = 'localhost';
$dbname = 'test_db';
$user = 'root';  // Change si tu utilises un autre utilisateur
$password = 'ton_mot_de_passe';  // Met ton mot de passe si nécessaire

// PS : il faudrait que chacun utilise son .env plutôt que de les marquer en dur

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Définir l'attribut de gestion des erreurs
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue
    die("Connection failed: " . $e->getMessage());
}
?>
