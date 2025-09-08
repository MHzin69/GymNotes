<?php

class PageController {
    private function render($view, $data = []) {
        extract($data);
        include __DIR__ . '/../View/partials/header.phtml';
        include __DIR__ . '/../View/' . $view . '.phtml';
        include __DIR__ . '/../View/partials/footer.phtml';
    }

    public function home() {
        $this->render('home', ['titulo' => 'Página Inicial']);
    }

    public function erro() {
        $this->render('erro', ['titulo' => 'Erro']);
    }
}