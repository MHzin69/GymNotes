<?php
namespace Src\Model;

use PDO;

class MedidasCorporaisDAO {
    public static function getAll(): array {
        $stmt = Database::getConnection()->query("SELECT * FROM medidas_corporais");
        $medidas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $medidas[] = new MedidasCorporais($row['id'], $row['usuario_id'], $row['peso'], $row['altura'], $row['data']);
        }
        return $medidas;
    }

    public static function getById(int $id): ?MedidasCorporais {
        $stmt = Database::getConnection()->prepare("SELECT * FROM medidas_corporais WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new MedidasCorporais($row['id'], $row['usuario_id'], $row['peso'], $row['altura'], $row['data']) : null;
    }

    public static function create(MedidasCorporais $medida): bool {
        $stmt = Database::getConnection()->prepare("INSERT INTO medidas_corporais (usuario_id, peso, altura, data) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$medida->getUsuarioId(), $medida->getPeso(), $medida->getAltura(), $medida->getData()]);
    }

    public static function update(MedidasCorporais $medida): bool {
        $stmt = Database::getConnection()->prepare("UPDATE medidas_corporais SET usuario_id = ?, peso = ?, altura = ?, data = ? WHERE id = ?");
        return $stmt->execute([$medida->getUsuarioId(), $medida->getPeso(), $medida->getAltura(), $medida->getData(), $medida->getId()]);
    }

    public static function delete(int $id): bool {
        $stmt = Database::getConnection()->prepare("DELETE FROM medidas_corporais WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
