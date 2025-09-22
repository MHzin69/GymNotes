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

    public static function getById(int $id_exercicio): ?Exercicio {
        try {
            $stmt = Database::getConnection()->prepare("SELECT * FROM exercicio WHERE id = ?");
            $stmt->execute([$id_exercicio]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                return null;
            }

            return new Exercicio(
                $row['id'],
                $row['nm_exercicio'],
                $row['gp_muscular'],
                $row['descricao'] // Nome da coluna corrigido
            );
        } catch (PDOException $e) {
            error_log("Erro ao buscar exercício: " . $e->getMessage());
            return null;
        }
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
    public static function getByGrupoMuscular(): array {
        try {
            $stmt = Database::getConnection()->query("SELECT * FROM exercicio ORDER BY gp_muscular");
            $exercicios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $exerciciosPorGrupo = [];
            foreach ($exercicios as $exercicio) {
                $grupo = $exercicio['gp_muscular'];
                if (!isset($exerciciosPorGrupo[$grupo])) {
                    $exerciciosPorGrupo[$grupo] = [];
                }
                $exerciciosPorGrupo[$grupo][] = $exercicio;
            }
            return $exerciciosPorGrupo;
        } catch (PDOException $e) {
            error_log("Erro ao buscar exercícios por grupo muscular: " . $e->getMessage());
            return [];
        }
    }
}
