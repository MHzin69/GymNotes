<?php
namespace Src\Model;

use PDO;

class TreinoExerciciosDAO {
    public static function getAll(): array {
        $stmt = Database::getConnection()->query("SELECT * FROM treino_exercicios");
        $treinos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $treinos[] = new TreinoExercicios($row['id'], $row['plano_id'], $row['exercicio_id'], $row['series'], $row['repeticoes']);
        }
        return $treinos;
    }

    public static function getById(int $id): ?TreinoExercicios {
        $stmt = Database::getConnection()->prepare("SELECT * FROM treino_exercicios WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new TreinoExercicios($row['id'], $row['plano_id'], $row['exercicio_id'], $row['series'], $row['repeticoes']) : null;
    }

    public static function create(TreinoExercicios $treino): bool {
        $stmt = Database::getConnection()->prepare("INSERT INTO treino_exercicios (plano_id, exercicio_id, series, repeticoes) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$treino->getPlanoId(), $treino->getExercicioId(), $treino->getSeries(), $treino->getRepeticoes()]);
    }

    public static function update(TreinoExercicios $treino): bool {
        $stmt = Database::getConnection()->prepare("UPDATE treino_exercicios SET plano_id = ?, exercicio_id = ?, series = ?, repeticoes = ? WHERE id = ?");
        return $stmt->execute([$treino->getPlanoId(), $treino->getExercicioId(), $treino->getSeries(), $treino->getRepeticoes(), $treino->getId()]);
    }

    public static function delete(int $id): bool {
        $stmt = Database::getConnection()->prepare("DELETE FROM treino_exercicios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
