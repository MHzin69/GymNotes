<?php
namespace Src\Model;

use PDO;

class HistoricoCargasDAO {
    public static function getAll(): array {
        $stmt = Database::getConnection()->query("SELECT * FROM historico_cargas");
        $historicos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $historicos[] = new HistoricoCargas($row['id'], $row['exercicio_id'], $row['carga'], $row['data']);
        }
        return $historicos;
    }

    public static function getById(int $id): ?HistoricoCargas {
        $stmt = Database::getConnection()->prepare("SELECT * FROM historico_cargas WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new HistoricoCargas($row['id'], $row['exercicio_id'], $row['carga'], $row['data']) : null;
    }

    public static function create(HistoricoCargas $hist): bool {
        $stmt = Database::getConnection()->prepare("INSERT INTO historico_cargas (exercicio_id, carga, data) VALUES (?, ?, ?)");
        return $stmt->execute([$hist->getExercicioId(), $hist->getCarga(), $hist->getData()]);
    }

    public static function update(HistoricoCargas $hist): bool {
        $stmt = Database::getConnection()->prepare("UPDATE historico_cargas SET exercicio_id = ?, carga = ?, data = ? WHERE id = ?");
        return $stmt->execute([$hist->getExercicioId(), $hist->getCarga(), $hist->getData(), $hist->getId()]);
    }

    public static function delete(int $id): bool {
        $stmt = Database::getConnection()->prepare("DELETE FROM historico_cargas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
