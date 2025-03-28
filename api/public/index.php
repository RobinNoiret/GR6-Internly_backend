<?php
require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Extraire l'URI de la requête
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Vérifier si la route correspond à /api/user/{id}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($requestUri[1]) && $requestUri[0] === 'api' && $requestUri[1] === 'user') {
    require_once('../routes/users.php');
    exit;
}

// Vérifier la méthode HTTP (GET)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['route'])) {
        switch ($_GET['route']) {
            case 'offers':
                require_once('../routes/offers.php');
                break;
            case 'offers_stats':
                require_once('../routes/offers_stats.php');
                break;
            case 'offers_duration':
                require_once('../routes/offers_duration.php');
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
            case 'entreprise_stats':
                require_once('../routes/entreprise_stats.php');
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
            case 'candidatures_with_details':
                require_once('../routes/candidatures_with_details.php');
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