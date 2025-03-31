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

    public function getUsersByStatus($status) {
        return $this->userModel->getUsersByStatus($status);
    }

    public function createUser($data) {
        if (!isset($data['nom'], $data['prenom'], $data['statut'], $data['email'], $data['password'])) {
            return [
                "success" => false,
                "error" => "Données incomplètes."
            ];
        }
    
        try {
            $userId = $this->userModel->createUser(
                $data['nom'],
                $data['prenom'],
                $data['statut'],
                $data['email'],
                $data['password']
            );
            return [
                "success" => true,
                "message" => "Utilisateur créé avec succès.",
                "id" => $userId
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }

    public function updateUser($id, $data) {
        if (!isset($data['nom'], $data['prenom'], $data['email'])) {
            return [
                "success" => false,
                "error" => "Données incomplètes."
            ];
        }
    
        try {
            $rowCount = $this->userModel->updateUser($id, $data['nom'], $data['prenom'], $data['email']);
            if ($rowCount > 0) {
                return [
                    "success" => true,
                    "message" => "Utilisateur mis à jour avec succès."
                ];
            } else {
                return [
                    "success" => false,
                    "error" => "Aucune modification effectuée ou utilisateur introuvable."
                ];
            }
        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }
}
?>