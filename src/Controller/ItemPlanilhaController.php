<?php
namespace Src\Controller;

use Src\Model\ItemPlanilha;
use Src\Model\ItemPlanilhaDAO;
use Src\Model\PlanilhaDAO;
use Src\Model\ExercicioDAO;

class ItemPlanilhaController {

   public static function adicionar(int $planilha_id, int $exercicio_id) {
    $planilha = PlanilhaDAO::getById($planilha_id);
    $exercicio = ExercicioDAO::getById($exercicio_id);

    if (!$planilha || !$exercicio) {
        header('Location: index.php?page=erro');
        exit;
    }

    // Chama o DAO diretamente com os valores para criar um item da planilha
    ItemPlanilhaDAO::create(
        $planilha_id,
        $exercicio_id,
        2,       // series (valor padrão)
        '8-12',  // repeticoes (valor padrão)
        null,    // carga
        null     // observacoes
    );

    header("Location: index.php?page=editarPlanilha&id={$planilha_id}");
    exit;
}
    public static function salvar(array $dados) {
        $planilha_id = $dados['planilha_id'] ?? null;
        if (!$planilha_id) {
            header('Location: index.php?page=erro');
            exit;
        }

        $item = new ItemPlanilha(
            null,
            $dados['planilha_id'],
            $dados['exercicio_id'],
            $dados['series'],
            $dados['repeticoes'],
            $dados['carga'],
            $dados['observacoes']
        );
        ItemPlanilhaDAO::create($item);

        header("Location: index.php?page=editarPlanilha&id={$planilha_id}");
        exit;
    }
    
    public static function deletar(int $id_item) {
        ItemPlanilhaDAO::delete($id_item);
    }
}