<?php
namespace Src\Model;

require_once "Database.php";

class UserModel {
    public static function getAllUsers() {
        $conn = Database::connect();
        $stmt = $conn->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function addUser($nome, $email) {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
        return $stmt->execute([$nome, $email]);
    }
}
