<?php
require_once __DIR__ . '/../config/database.php'; // Assurez-vous que ce fichier configure la connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées dans le corps de la requête
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['offre_id']) && isset($data['utilisateur_id'])) {
        $offre_id = $data['offre_id'];
        $utilisateur_id = $data['utilisateur_id'];

        try {
            // Préparer la requête SQL pour supprimer l'entrée
            $query = "DELETE FROM wishlist WHERE offre_id = :offre_id AND utilisateur_id = :utilisateur_id";
            $stmt = $pdo->prepare($query);

            // Exécuter la requête
            $stmt->execute([
                ':offre_id' => $offre_id,
                ':utilisateur_id' => $utilisateur_id,
            ]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(["success" => true, "message" => "Offre supprimée de la wishlist"]);
            } else {
                echo json_encode(["success" => false, "error" => "Aucune entrée trouvée pour ces paramètres"]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Paramètres manquants"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée"]);
}
?>