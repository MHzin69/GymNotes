<?php
namespace Src\Controller;

use Src\Model\PlanilhaDAO; // Garanta que esta linha está aqui

class PageController {
    private function render($view, $data = []) {
        extract($data);
        include __DIR__ . '/../View/partials/header.phtml';
        include __DIR__ . '/../View/' . $view . '.phtml';
        include __DIR__ . '/../View/partials/footer.phtml';
    }

    public function home() {
        // Busca as planilhas prontas no banco de dados
        $planilhasProntas = PlanilhaDAO::getTemplates();
        
        // Passa as planilhas para a view
        $this->render('home', ['planilhasProntas' => $planilhasProntas]);
    }

    public function erro() {
        $this->render('erro', ['titulo' => 'Erro']);
    }
}