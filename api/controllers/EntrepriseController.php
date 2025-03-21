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
}
?>