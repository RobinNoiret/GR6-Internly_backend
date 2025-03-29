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
}
?>