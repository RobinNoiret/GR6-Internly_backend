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
}
?>