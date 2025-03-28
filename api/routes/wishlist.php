<?php

require_once('../config/database.php');
require_once('../controllers/OfferController.php');

$offerController = new OfferController($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['user_id'])) {
        $userId = intval($_GET['user_id']);
        $wishlist = $offerController->getWishlistByUserId($userId);
        echo json_encode($wishlist);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "User ID is required"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
}
?>