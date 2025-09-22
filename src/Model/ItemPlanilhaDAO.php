<?php
namespace Src\Model;

use PDO;
use PDOException;

class ItemPlanilhaDAO {
    // Busca todos os exercícios de uma planilha específica
    public static function getByPlanilhaId(int $id_planilha): array {
        try {
            $stmt = Database::getConnection()->prepare(
                "SELECT ip.*, e.nm_exercicio, e.gp_muscular, e.ds_exercicio
                FROM item_planilha ip
                JOIN exercicio e ON ip.id_exercicio = e.id
                WHERE ip.id_planilha = ?"
            );
            $stmt->execute([$id_planilha]);
            $itens = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $itens[] = $row; // Retorna um array associativo com todos os dados
            }
            return $itens;
        } catch (PDOException $e) {
            error_log("Erro ao buscar itens da planilha: " . $e->getMessage());
            return [];
        }
    }

    // Adiciona um novo exercício à planilhapublic static function create(int $planilha_id, int $exercicio_id, ?int $series, ?string $repeticoes, ?string $carga, ?string $observacoes): bool {
    public static function create(int $planilha_id, int $exercicio_id, ?int $series, ?string $repeticoes, ?string $carga, ?string $observacoes): bool {
    try {
        $conn = Database::getConnection();
        $stmt = $conn->prepare(
            "INSERT INTO item_planilha (id_planilha, id_exercicio, series, repeticoes, carga, observacoes) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        return $stmt->execute([
            $planilha_id,
            $exercicio_id,
            $series,
            $repeticoes,
            $carga,
            $observacoes
        ]);
    } catch (PDOException $e) {
        error_log("Erro ao adicionar item na planilha: " . $e->getMessage());
        return false;
    }
}
    
    // Deleta um item da planilha
    public static function delete(int $id_item): bool {
        try {
            $stmt = Database::getConnection()->prepare("DELETE FROM item_planilha WHERE id = ?");
            return $stmt->execute([$id_item]);
        } catch (PDOException $e) {
            error_log("Erro ao deletar item da planilha: " . $e->getMessage());
            return false;
        }
    }
}