<?php

require_once('../models/User.php');

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }

    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }

    public function getUserById($id) {
        return $this->userModel->getUserById($id);
    }

    public function countStudents() {
        return $this->userModel->countStudents();
    }

    public function loginUser($email, $password) {
        return $this->userModel->loginUser($email, $password);
    }

    public function getUserDetailsById($id) {
        return $this->userModel->getUserDetailsById($id);
    }

    // Nouvelle méthode pour récupérer les utilisateurs par statut
    public function getUsersByStatus($status) {
        return $this->userModel->getUsersByStatus($status);
    }

    public function getUserFirstNameById($id) {
        return $this->userModel->getUserFirstNameById($id);
    }
}
?>