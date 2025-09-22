<?php
namespace Src\Controller;

use Src\Model\PlanoTreino;
use Src\Model\PlanoTreinoDAO;

class PlanosTreinoController {
    public static function listar() { return PlanoTreinoDAO::getAll(); }
    public static function ver(int $id) { return PlanoTreinoDAO::getById($id); }
    public static function criar(array $dados) { return PlanoTreinoDAO::create(new PlanoTreino(null, $dados['nome'], $dados['descricao'])); }
    public static function atualizar(int $id, array $dados) { return PlanoTreinoDAO::update(new PlanoTreino($id, $dados['nome'], $dados['descricao'])); }
    public static function deletar(int $id) { return PlanoTreinoDAO::delete($id); 
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
    public function editar(int $id_planilha) {
    $planilha = PlanilhaDAO::getById($id_planilha);

    if (!$planilha) {
        // Redireciona para a página de erro se a planilha não for encontrada
        header('Location: index.php?page=erro');
        exit;
    }

    // Carrega a view de edição com os dados da planilha
    require_once __DIR__ . '/../View/EditarPlanilha.phtml';
}
}
