<?php

require_once('../models/Entreprise.php');

class EntrepriseController {
    private $entrepriseModel;

    public function __construct($pdo) {
        $this->entrepriseModel = new Entreprise($pdo);
    }

    public function getAllEntreprises() {
        return $this->entrepriseModel->getAllEntreprises();
    }

    public function getEntrepriseById($id) {
        return $this->entrepriseModel->getEntrepriseById($id);
    }

    public function countEntreprises() {
        return $this->entrepriseModel->countEntreprises();
    }

    public function getTopRatedEntreprises() {
        return $this->entrepriseModel->getTopRatedEntreprises();
    }
    
    public function getEntrepriseCountByDomain() {
        return $this->entrepriseModel->getEntrepriseCountByDomain();
    }

    public function createEntreprise($data) {
        return $this->entrepriseModel->createEntreprise(
            $data['nom'],
            $data['description'],
            $data['email'],
            $data['telephone'],
            $data['domaine'],
            $data['visibilite']
        );
    }

    public function deleteEntreprise($id) {
        try {
            $rowCount = $this->entrepriseModel->deleteEntreprise($id);
            return [
                "success" => true,
                "message" => "Entreprise supprimée avec succès.",
                "deleted_rows" => $rowCount
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    public function updateEntreprise($id, $data) {
        try {
            // Vérifier que toutes les données nécessaires sont présentes
            if (!isset($data['nom'], $data['description'], $data['email'], $data['telephone'], $data['domaine'], $data['visibilite'])) {
                return [
                    "success" => false,
                    "error" => "Données incomplètes."
                ];
            }
    
            // Appeler la méthode du modèle pour mettre à jour l'entreprise
            $rowCount = $this->entrepriseModel->updateEntreprise(
                $id,
                $data['nom'],
                $data['description'],
                $data['email'],
                $data['telephone'],
                $data['domaine'],
                $data['visibilite']
            );
    
            return [
                "success" => true,
                "message" => "Entreprise mise à jour avec succès.",
                "rows_affected" => $rowCount
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}
?>