<?php

require_once('../config/database.php');
require_once('../controllers/UserController.php');

$userController = new UserController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $user = $userController->getUserById($_GET['id']);
        echo json_encode($user);
    } elseif (isset($_GET['count']) && $_GET['count'] == 'students') {
        $count = $userController->countStudents();
        echo json_encode($count);
    } else {
        $users = $userController->getAllUsers();
        echo json_encode($users);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
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

