<?php
namespace Src\Controller;

use Src\Model\PlanilhaDAO;

class DashboardController {
    public function index(int $usuarioId) {
        $planilhas = PlanilhaDAO::getByUsuarioId($usuarioId);
        // Caminho corrigido
        require_once __DIR__ . '/../View/Planilhas.phtml';
    }
}