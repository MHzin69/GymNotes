<?php
namespace Src\Model;

use PDO;

class PlanoTreinoDAO {
    public static function getAll(): array {
        $stmt = Database::getConnection()->query("SELECT * FROM planos_treino");
        $planos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $planos[] = new PlanoTreino($row['id'], $row['nome'], $row['descricao']);
        }
        return $planos;
    }

    public static function getById(int $id): ?PlanoTreino {
        $stmt = Database::getConnection()->prepare("SELECT * FROM planos_treino WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new PlanoTreino($row['id'], $row['nome'], $row['descricao']) : null;
    }

    public static function create(PlanoTreino $plano): bool {
        $stmt = Database::getConnection()->prepare("INSERT INTO planos_treino (nome, descricao) VALUES (?, ?)");
        return $stmt->execute([$plano->getNome(), $plano->getDescricao()]);
    }

    public static function update(PlanoTreino $plano): bool {
        $stmt = Database::getConnection()->prepare("UPDATE planos_treino SET nome = ?, descricao = ? WHERE id = ?");
        return $stmt->execute([$plano->getNome(), $plano->getDescricao(), $plano->getId()]);
    }

    public static function delete(int $id): bool {
        $stmt = Database::getConnection()->prepare("DELETE FROM planos_treino WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
