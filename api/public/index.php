<?php
header('Content-Type: application/json'); // Déclare le format de la réponse
header('Access-Control-Allow-Origin: *'); // Permet les requêtes depuis n'importe quelle origine
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Permet les méthodes HTTP spécifiques
header('Access-Control-Allow-Headers: Content-Type'); // Permet les en-têtes spécifiques

// Inclure le fichier de routes
require_once('../routes/users.php');

// Vérifier la méthode HTTP (GET)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Récupérer les utilisateurs
    $users = getUsers();
    // Retourner les utilisateurs en format JSON
    echo json_encode($users);
} else {
    // Méthode non autorisée
    echo json_encode(["error" => "Method not allowed"]);
}
?>
