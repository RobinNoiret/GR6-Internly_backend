<?php

require_once('../models/Adresse.php');

class AdresseController {
    private $adresseModel;

    public function __construct($pdo) {
        $this->adresseModel = new Adresse($pdo);
    }

    public function getAllAdresses() {
        return $this->adresseModel->getAllAdresses();
    }

    public function getAdresseById($id) {
        return $this->adresseModel->getAdresseById($id);
    }
}
?>