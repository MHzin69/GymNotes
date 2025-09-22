<?php
namespace Src\Model;

use PDO;
use PDOException;

class PlanilhaDAO
{
    // Método para buscar todas as planilhas de um usuário
    public static function getByUsuarioId(int $id_usuario): array
    {
        try {
            $stmt = Database::getConnection()->prepare("SELECT * FROM planilha WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            $planilhas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $planilhas[] = new Planilha($row['id'], $row['id_usuario'], $row['nm_planilha'], $row['descricao']);
            }
            return $planilhas;
        } catch (PDOException $e) {
            error_log("Erro ao buscar planilhas do usuário: " . $e->getMessage());
            return [];
        }
    }

    public static function getById(int $id_planilha): ?Planilha
    {
        try {
            $stmt = Database::getConnection()->prepare("SELECT * FROM planilha WHERE id = ?");
            $stmt->execute([$id_planilha]); // Note que o execute usa a variável correta
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verifica se a linha foi encontrada e cria um novo objeto Planilha
            return $row ? new Planilha(
                $row['id'],
                $row['id_usuario'],
                $row['nm_planilha'],
                $row['descricao']
            ) : null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar planilha: " . $e->getMessage());
            return null;
        }
    }

    public static function create(Planilha $planilha): bool
    {
        try {
            $stmt = Database::getConnection()->prepare(
                "INSERT INTO planilha (id_usuario, nm_planilha, descricao) VALUES (?, ?, ?)"
            );
            return $stmt->execute([
                $planilha->getIdUsuario(),
                $planilha->getNmPlanilha(),
                $planilha->getDescricao()
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao criar planilha: " . $e->getMessage());
            return false;
        }
    }

    public static function getTemplates(): array
    {
        try {
            $stmt = Database::getConnection()->prepare("SELECT * FROM planilha WHERE is_template = ?");
            $stmt->execute([1]);

            $planilhas = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Cria um objeto Planilha a partir dos dados do banco
                $planilhas[] = new planilha($row['id'], $row['id_usuario'], $row['nm_planilha'], $row['descricao']);
            }
            return $planilhas;
        } catch (PDOException $e) {
            error_log("Erro ao buscar templates: " . $e->getMessage());
            return [];
        }
    }
    public static function update(Planilha $planilha): bool
    {
        try {
            $stmt = Database::getConnection()->prepare(
                "UPDATE planilha SET nm_planilha = ?, descricao = ? WHERE id = ?"
            );
            return $stmt->execute([
                $planilha->getNmPlanilha(),
                $planilha->getDescricao(),
                $planilha->getId()
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar planilha: " . $e->getMessage());
            return false;
        }
    }
}