<?php
namespace Src\Model;

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/User.php';

use PDO;

class UserDAO {
    public static function getAll(): array {
        $conn = Database::connect();
        $sql = "SELECT id, nome, email FROM usuario";
        $stmt = $conn->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $r) {
            $users[] = User::fromArray($r);
        }
        return $users;
    }

    public static function add(User $user): int {
        $conn = Database::connect();
        $hashed = null;
        if ($user->getSenha()) {
            $hashed = password_hash($user->getSenha(), PASSWORD_DEFAULT);
        }

        $sql = "INSERT INTO usuario (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':nome', $user->getNome());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':senha', $hashed);
        $stmt->execute();

        return (int)$conn->lastInsertId();
    }

    public static function getById(int $id): ?User {
        $conn = Database::connect();
        $sql = "SELECT id, nome, email, senha FROM usuario WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? User::fromArray($row) : null;
    }

    public static function update(User $user): bool {
        $conn = Database::connect();
        $fields = "nome = :nome, email = :email";
        $params = [
            ':nome' => $user->getNome(),
            ':email' => $user->getEmail(),
            ':id' => $user->getId()
        ];

        if ($user->getSenha()) {
            $fields .= ", senha = :senha";
            $params[':senha'] = password_hash($user->getSenha(), PASSWORD_DEFAULT);
        }

        $sql = "UPDATE usuario SET {$fields} WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }

    public static function delete(int $id): bool {
        $conn = Database::connect();
        $sql = "DELETE FROM usuario WHERE id = :id";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
