<?php
header('Content-Type: application/json'); // Déclare le format de la réponse
header('Access-Control-Allow-Origin: *'); // Permet les requêtes depuis n'importe quelle origine
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Permet les méthodes HTTP spécifiques
header('Access-Control-Allow-Headers: Content-Type'); // Permet les en-têtes spécifiques

// Inclure les fichiers de routes
require_once('../routes/users.php');
require_once('../routes/offers.php');
require_once('../routes/adresse.php');
//require_once('../routes/appartenir.php');
require_once('../routes/candidatures.php');
//require_once('../routes/competence.php');
//require_once('../routes/competence_offre.php');
require_once('../routes/entreprise.php');
require_once('../routes/evaluations.php');
//require_once('../routes/promotion.php');
//require_once('../routes/ville.php');
//require_once('../routes/wishlist.php');

// Vérifier la méthode HTTP (GET)
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['route'])) {
        switch ($_GET['route']) {
            case 'offers':
                $offers = getOffers();
                echo json_encode($offers);
                break;
            case 'adresses':
                $adresses = getAdresses();
                echo json_encode($adresses);
                break;
            /*
            case 'appartenir':
                $appartenir = getAppartenir();
                echo json_encode($appartenir);
                break;
            */
            case 'candidatures':
                $candidatures = getCandidatures();
                echo json_encode($candidatures);
                break;
            /*
            case 'competence':
                $competence = getCompetence();
                echo json_encode($competence);
                break;
            case 'competence_offre':
                $competence_offre = getCompetenceOffre();
                echo json_encode($competence_offre);
                break;
            */
            case 'entreprise':
                if (isset($_GET['id'])) {
                    $entreprise = getEntrepriseById($_GET['id']);
                    echo json_encode($entreprise);
                } else {
                    $entreprise = getEntreprise();
                    echo json_encode($entreprise);
                }
                break;
            case 'evaluations':
                $evaluations = getEvaluations();
                echo json_encode($evaluations);
                break;
            /*
            case 'promotion':
                $promotion = getPromotion();
                echo json_encode($promotion);
                break;
            case 'ville':
                $ville = getVille();
                echo json_encode($ville);
                break;
            case 'wishlist':
                $wishlist = getWishlist();
                echo json_encode($wishlist);
                break;
            */
            case 'users':
                $users = getUsers();
                echo json_encode($users);
                break;
        }
    } else {
        $users = getUsers();
        echo json_encode($users);
    }
} else {
    echo json_encode(["error" => "Method not allowed"]);
}
?>
