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

// Nouvelle fonction pour gérer la route /api/login
function loginUser($email, $password) {
    global $pdo;

    // Rechercher l'utilisateur par email
    $stmt = $pdo->prepare("SELECT utilisateur_id, utilisateur_email, utilisateur_statut, utilisateur_password FROM utilisateur WHERE utilisateur_email = :email");
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['utilisateur_password'])) {
        // Connexion réussie, retourner les informations de l'utilisateur
        header('Content-Type: application/json');
        echo json_encode([
            "id" => $user['utilisateur_id'],
            "email" => $user['utilisateur_email'],
            "status" => $user['utilisateur_statut'] === 'admin' ? 'admin' : 'user'
        ]);
        exit; // Arrêtez l'exécution après avoir envoyé la réponse
    } else {
        // Échec de la connexion
        http_response_code(401);
        echo json_encode(["error" => "Invalid email or password"]);
        exit; // Arrêtez l'exécution après avoir envoyé la réponse
    }
}

?>
