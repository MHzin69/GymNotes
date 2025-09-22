<?php
namespace Src\Controller;

use Src\Model\PlanilhaModel;

class PlanilhaController {
    public function listar($usuarioId) {
        $model = new PlanilhaModel();
        $planilhas = $model->getPlanilhasByUsuario($usuarioId);

        require __DIR__ . "/../../views/planilha.phtml";
    }
}
