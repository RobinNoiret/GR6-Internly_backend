<?php

require_once('../config/database.php');
require_once('../controllers/EntrepriseController.php');

$entrepriseController = new EntrepriseController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    var_dump($data);

    if (isset($data['id'])) {
        try {
            $deletedRows = $entrepriseController->deleteEntreprise($data['id']);
            if ($deletedRows > 0) {
                echo json_encode(["success" => true, "message" => "Entreprise supprimée avec succès."]);
            } else {
                echo json_encode(["success" => false, "error" => "Aucune entreprise trouvée avec cet ID."]);
            }
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "ID de l'entreprise manquant."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Méthode non autorisée."]);
}
?>