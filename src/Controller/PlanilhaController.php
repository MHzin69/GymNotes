<?php
namespace Src\Controller;

use Src\Model\Planilha;
use Src\Model\PlanilhaDAO;
use Src\Model\ItemPlanilhaDAO;

class PlanilhaController {

    // Método para exibir a página de criação
    public static function criar() {
        require_once __DIR__ . '/../View/CriarPlanilha.phtml';
    }

    // Método para salvar a planilha no banco (chamado pelo form)
    public static function salvar(array $dados) {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header('Location: index.php?page=login');
            exit;
        }

        if (!isset($dados['nm_planilha'])) {
            header('Location: index.php?page=criarPlanilha');
            exit;
        }

        $planilha = new Planilha(
            null,
            $id_usuario,
            $dados['nm_planilha'],
            $dados['descricao'] ?? ''
        );

        PlanilhaDAO::create($planilha);
        header('Location: index.php?page=planilhas');
        exit;
    }

    // Método para exibir a página de edição
    public static function editar(int $id_planilha) {
        $planilha = PlanilhaDAO::getById($id_planilha);
        $exercicios = ItemPlanilhaDAO::getByPlanilhaId($id_planilha);

        if (!$planilha) {
            header('Location: index.php?page=erro');
            exit;
        }

        require_once __DIR__ . '/../View/EditarPlanilha.phtml';
    }

    // Método para exibir a página de visualização
    public static function ver(int $id_planilha) {
    $planilha = PlanilhaDAO::getById($id_planilha);
    $exercicios = ItemPlanilhaDAO::getByPlanilhaId($id_planilha);

    if (!$planilha) {
        header('Location: index.php?page=erro');
        exit;
    }


    require_once __DIR__ . '/../View/VerPlanilha.phtml';
}

    // --- MÉTODOS DE AÇÃO ---

    public static function atualizar(int $id, array $dados) {
        $id_usuario = $_SESSION['usuario_id'] ?? null;
        if (!$id_usuario) {
            header('Location: index.php?page=login');
            exit;
        }

        $planilha = new Planilha(
            $id,
            $id_usuario,
            $dados['nm_planilha'],
            $dados['descricao']
        );
        PlanilhaDAO::update($planilha);
        header('Location: index.php?page=planilhas');
        exit;
    }
    
    public static function deletar(int $id) {
        return PlanilhaDAO::delete($id);
    }
    
    public static function copiar(int $id_planilha, int $id_usuario) {
        $planilhaPronta = PlanilhaDAO::getById($id_planilha);

        if ($planilhaPronta) {
            $novaPlanilha = new Planilha(
                null,
                $id_usuario,
                'Cópia de ' . $planilhaPronta->getNmPlanilha(),
                $planilhaPronta->getDescricao()
            );
            PlanilhaDAO::create($novaPlanilha);
            
            header('Location: index.php?page=planilhas');
            exit;
        } else {
            header('Location: index.php?page=planilhas');
            exit;
        }
    }
}