<?php
require_once __DIR__ . '/../src/Controller/PageController.php';
require_once __DIR__ . '/../src/Controller/LoginController.php';

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

    case 'cadastro': // 👈 rota nova
        $controller = new LoginController();
        $controller->cadastro();
        break;

    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;

    default:
        $controller = new PageController();
        $controller->erro();
        break;
}
