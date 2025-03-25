<?php

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM utilisateur");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE utilisateur_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countStudents() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS student_count FROM utilisateur WHERE utilisateur_statut = 'etudiant'");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function loginUser($email, $password) {
        $stmt = $this->pdo->prepare("SELECT utilisateur_id, utilisateur_email, utilisateur_statut, utilisateur_password FROM utilisateur WHERE utilisateur_email = :email");
        $stmt->execute([':email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['utilisateur_password'])) {
            return [
                "id" => $user['utilisateur_id'],
                "email" => $user['utilisateur_email'],
                "status" => $user['utilisateur_statut'] === 'admin' ? 'admin' : 'user'
            ];
        } else {
            return null; // Retourne null en cas d'échec
        }
    }
}
?>