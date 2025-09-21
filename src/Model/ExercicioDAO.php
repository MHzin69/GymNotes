<?php
namespace Src\Model;

use PDO;

class ExercicioDAO {
    public static function getAll(): array {
        $stmt = Database::getConnection()->query("SELECT * FROM exercicios");
        $exercicios = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $exercicios[] = new Exercicio($row['id'], $row['nome'], $row['descricao']);
        }
        return $exercicios;
    }

    public static function getById(int $id): ?Exercicio {
        $stmt = Database::getConnection()->prepare("SELECT * FROM exercicios WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Exercicio($row['id'], $row['nome'], $row['descricao']) : null;
    }

    public static function create(Exercicio $exercicio): bool {
        $stmt = Database::getConnection()->prepare("INSERT INTO exercicios (nome, descricao) VALUES (?, ?)");
        return $stmt->execute([$exercicio->getNome(), $exercicio->getDescricao()]);
    }

    public static function update(Exercicio $exercicio): bool {
        $stmt = Database::getConnection()->prepare("UPDATE exercicios SET nome = ?, descricao = ? WHERE id = ?");
        return $stmt->execute([$exercicio->getNome(), $exercicio->getDescricao(), $exercicio->getId()]);
    }

    public static function delete(int $id): bool {
        $stmt = Database::getConnection()->prepare("DELETE FROM exercicios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
