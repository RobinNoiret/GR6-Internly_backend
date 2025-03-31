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
                "status" => $user['utilisateur_statut']
            ];
        } else {
            return null; // Retourne null en cas d'échec
        }
    }

    public function getUserDetailsById($id) {
        $stmt = $this->pdo->prepare("SELECT utilisateur_nom, utilisateur_prenom, utilisateur_email FROM utilisateur WHERE utilisateur_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsersByStatus($status) {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE utilisateur_statut = :status");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getUserFirstNameById($id) {
        $stmt = $this->pdo->prepare("SELECT utilisateur_prenom FROM utilisateur WHERE utilisateur_id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } // Add this closing brace
    
    public function createUser($nom, $prenom, $statut, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hachage du mot de passe
        $stmt = $this->pdo->prepare("
            INSERT INTO utilisateur (utilisateur_nom, utilisateur_prenom, utilisateur_statut, utilisateur_email, utilisateur_password)
            VALUES (:nom, :prenom, :statut, :email, :password)
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':statut' => $statut,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateUser($id, $nom, $prenom, $email) {
        $stmt = $this->pdo->prepare("
            UPDATE utilisateur
            SET utilisateur_nom = :nom, utilisateur_prenom = :prenom, utilisateur_email = :email
            WHERE utilisateur_id = :id
        ");
        $stmt->execute([
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email
        ]);
    
        return $stmt->rowCount();
    }
}
?>