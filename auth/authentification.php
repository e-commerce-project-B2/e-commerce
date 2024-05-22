<?php

// classe d'authentification
class Authentification
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // authentification de l'administrateur
    public function authenticateAdmin($email, $password)
    {
        $query = "SELECT * FROM admins WHERE email = :email";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier le mot de passe
            if ($password === $admin['password']) {
                // Authentification réussie
                return true;
            }
        }
        // Identifiants incorrects
        return false;
    }

}
