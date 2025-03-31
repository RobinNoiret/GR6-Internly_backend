<?php

require_once('../models/Candidature.php');

class CandidatureController {
    private $candidatureModel;

    public function __construct($pdo) {
        $this->candidatureModel = new Candidature($pdo);
    }

    public function getAllCandidatures() {
        return $this->candidatureModel->getAllCandidatures();
    }

    public function getCandidatureById($id) {
        return $this->candidatureModel->getCandidatureById($id);
    }

    public function getCandidaturesWithDetails() {
        return $this->candidatureModel->getCandidaturesWithDetails();
    }

    public function getCandidaturesByUserId($userId) {
        return $this->candidatureModel->getCandidaturesByUserId($userId);
    }

    public function getCandidatureCountByStatusForUser($userId) {
        return $this->candidatureModel->getCandidatureCountByStatusForUser($userId);
    }

    public function createCandidature($data, $cvFile) {
        if (!isset($data['offre_id'], $data['utilisateur_id'], $data['lettre_motivation'])) {
            return ["success" => false, "error" => "Données incomplètes."];
        }
    
        // Définir le chemin pour le fichier CV
        $uploadDir = __DIR__ . '/../../public/uploads/cv/';
        $cvPath = $uploadDir . uniqid() . '_' . basename($cvFile['name']);
    
        // Vérifiez si le répertoire existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
    
        // Déplacer le fichier téléchargé
        if (!move_uploaded_file($cvFile['tmp_name'], $cvPath)) {
            return ["success" => false, "error" => "Échec du téléchargement du fichier."];
        }
    
        // Appeler la méthode du modèle
        return $this->candidatureModel->createCandidature(
            $data['offre_id'],
            $data['utilisateur_id'],
            $data['lettre_motivation'],
            'uploads/cv/' . basename($cvPath) // Chemin relatif pour la base de données
        );
    }
}
?>