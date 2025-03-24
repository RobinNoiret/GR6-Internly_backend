<?php
require 'api/config/database.php'; // Inclure votre configuration PDO

try {
    // Récupérer tous les utilisateurs avec leurs mots de passe en clair
    $stmt = $pdo->query("SELECT utilisateur_id, utilisateur_password FROM utilisateur");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Hacher le mot de passe existant
        $hashedPassword = password_hash($row['utilisateur_password'], PASSWORD_DEFAULT);

        // Mettre à jour la colonne utilisateur_password avec le mot de passe haché
        $updateStmt = $pdo->prepare("UPDATE utilisateur SET utilisateur_password = :hashedPassword WHERE utilisateur_id = :id");
        $updateStmt->execute([
            ':hashedPassword' => $hashedPassword,
            ':id' => $row['utilisateur_id']
        ]);

        echo "Mot de passe haché pour l'utilisateur ID " . $row['utilisateur_id'] . "\n";
    }
    echo "Tous les mots de passe ont été hachés avec succès.\n";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>