<?php
require_once __DIR__ . '/../src/Controller/PageController.php';

$controller = new PageController();

// rota vinda pela URL
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':
        $controller->home();
        break;
    default:
        $controller->erro();
        break;
}
