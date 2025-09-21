<?php
namespace Src\Model;

use PDO;
use PDOException;

class UserDAO {
    public static function getAll(): array {
        try {
            $stmt = Database::getConnection()->query("SELECT * FROM usuarios");
            $users = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $users[] = new User($row['id'], $row['nome'], $row['email'], $row['senha']);
            }
            return $users;
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuários: " . $e->getMessage());
            return [];
        }
    }

    public static function getById(int $id): ?User {
        try {
            $stmt = Database::getConnection()->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? new User($row['id'], $row['nome'], $row['email'], $row['senha']) : null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário: " . $e->getMessage());
            return null;
        }
    }

    public static function create(User $user): bool {
        try {
            $stmt = Database::getConnection()->prepare(
                "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"
            );
            return $stmt->execute([
                $user->getNome(),
                $user->getEmail(),
                password_hash($user->getSenha(), PASSWORD_BCRYPT) // segurança
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar usuário: " . $e->getMessage());
            return false;
        }
    }

    public static function update(User $user): bool {
        try {
            $stmt = Database::getConnection()->prepare(
                "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?"
            );
            return $stmt->execute([
                $user->getNome(),
                $user->getEmail(),
                password_hash($user->getSenha(), PASSWORD_BCRYPT),
                $user->getId()
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar usuário: " . $e->getMessage());
            return false;
        }
    }

    public static function delete(int $id): bool {
        try {
            $stmt = Database::getConnection()->prepare("DELETE FROM usuarios WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erro ao deletar usuário: " . $e->getMessage());
            return false;
        }
    }
}
