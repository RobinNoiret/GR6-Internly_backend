<?php
require_once __DIR__ . '/../../vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Extraire l'URI de la requête
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Vérifier si la route correspond à /api/user/{id}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($requestUri[1]) && $requestUri[0] === 'api' && $requestUri[1] === 'user') {
    require_once('../routes/users.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si la requête est pour /api/login
    if ($requestUri[0] === 'api' && $requestUri[1] === 'login') {
        require_once('../routes/users.php');
        exit;
    }

    elseif (isset($_GET['route'])) {
        switch ($_GET['route']) {
            case 'add_to_wishlist':
                require_once('../routes/add_to_wishlist.php');
                break;
            case 'remove_from_wishlist': // Nouvelle route pour supprimer de la wishlist
                require_once('../routes/remove_from_wishlist.php');
                break;
            case 'create_entreprise':
                require_once('../routes/create_entreprise.php');
                break;
        }
    } else {
        echo json_encode(["error" => "POST - Route not specified"]);
        exit;
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['route'])) {
        switch ($_GET['route']) {
            case 'delete_entreprise':
                require_once('../routes/delete_entreprise.php');
                break;
            default:
                echo json_encode(["error" => "DELETE - Route not found"]);
                exit;
        }
    } else {
        echo json_encode(["error" => "DELETE - Route not specified"]);
        exit;
    }
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
            case 'wishlist_status':
                require_once('../routes/wishlist_status.php');
                break;
            case 'candidatures_with_details':
                require_once('../routes/candidatures_with_details.php');
                break;
            case 'wishlist':
                require_once('../routes/wishlist.php');
                break;
            case 'candidatures_by_user':
                require_once('../routes/candidatures.php');
                break;
            default:
                echo json_encode(["error" => "Route not found"]);
                exit;
        }
    } else {
        echo json_encode(["error" => "GET - Route not specified"]);
        exit;
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}
?>