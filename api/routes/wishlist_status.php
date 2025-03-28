<?php
require_once('../config/database.php');

if (isset($_GET['offre_id']) && isset($_GET['utilisateur_id'])) {
    $offreId = intval($_GET['offre_id']);
    $utilisateurId = intval($_GET['utilisateur_id']);

    try {
        // Préparer la requête pour vérifier si l'entrée existe dans la wishlist
        $query = "SELECT COUNT(*) AS count FROM wishlist WHERE offre_id = :offre_id AND utilisateur_id = :utilisateur_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':offre_id' => $offreId,
            ':utilisateur_id' => $utilisateurId,
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourner true si l'entrée existe, sinon false
        if ($result['count'] > 0) {
            echo json_encode(["isWishlisted" => true]);
        } else {
            echo json_encode(["isWishlisted" => false]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Missing parameters"]);
}
?>