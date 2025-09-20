<?php
require_once __DIR__ . '/../src/Controller/PageController.php';
require_once __DIR__ . '/../src/Controller/LoginController.php';
require_once __DIR__ . '/../src/Controller/PlanilhaController.php';

session_start();

// rota vinda pela URL
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        $controller = new PageController();
        $controller->home();
        break;

    case 'login':
        $controller = new LoginController();
        $controller->index();
        break;

    case 'autenticar':
        $controller = new LoginController();
        $controller->autenticar();
        break;

    case 'cadastro':
        $controller = new LoginController();
        $controller->cadastro();
        break;

    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;


    case 'planilhas':   // lista todas as planilhas do usuário
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new PlanilhaController();
        $controller->listar($_SESSION['usuario_id']);
        break;

    case 'criarPlanilha': // mostra o form de criação
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new PlanilhaController();
        $controller->criar($_SESSION['usuario_id']);
        break;

    case 'salvarPlanilha': // rota para salvar no banco (POST)
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new PlanilhaController();
        $controller->salvar($_SESSION['usuario_id']);
        break;

    default:
        $controller = new PageController();
        $controller->erro();
        break;
}
