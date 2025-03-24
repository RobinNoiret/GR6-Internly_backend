<?php
require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/api/login') {
    // Récupérer les données envoyées dans la requête POST
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['email']) && isset($data['password'])) {
        echo loginUser($data['email'], $data['password']);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Email and password are required"]);
    }
}


// Vérifier la méthode HTTP (GET)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['route'])) {
        switch ($_GET['route']) {
            case 'offers':
                require_once('../routes/offers.php');
                break;
            case 'adresses':
                require_once('../routes/adresse.php');
                break;
            case 'candidatures':
                require_once('../routes/candidatures.php');
                break;
            case 'entreprise':
                require_once('../routes/entreprise.php');
                break;
            case 'evaluations':
                require_once('../routes/evaluations.php');
                break;
            case 'users':
                require_once('../routes/users.php');
                break;
            case 'offers_display':
                require_once('../routes/offers_display.php');
                break;
            default:
                echo json_encode(["error" => "Route not found"]);
                exit;
        }
    } else {
        echo json_encode(["error" => "Route not specified"]);
        exit;
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}
?>