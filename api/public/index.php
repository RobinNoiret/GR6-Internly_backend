<?php
require_once '../../vendor/autoload.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once('../routes/users.php');
require_once('../routes/offers.php');
require_once('../routes/adresse.php');
require_once('../routes/candidatures.php');
require_once('../routes/entreprise.php');
require_once('../routes/evaluations.php');

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
            default:
                echo json_encode(["error" => "Route not found"]);
        }
    } else {
        echo json_encode(["error" => "Route not specified"]);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>