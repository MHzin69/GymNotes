<?php
// Carrega todas as classes necessárias de forma organizada
require_once __DIR__ . '/../src/Controller/PageController.php';
require_once __DIR__ . '/../src/Controller/UsuariosController.php';
require_once __DIR__ . '/../src/Controller/PlanilhaController.php';
require_once __DIR__ . '/../src/Controller/DashboardController.php';
require_once __DIR__ . '/../src/Model/Database.php';
require_once __DIR__ . '/../src/Model/UserDAO.php';
require_once __DIR__ . '/../src/Model/User.php';
require_once __DIR__ . '/../src/Model/PlanilhaDAO.php';
require_once __DIR__ . '/../src/Model/Planilha.php';

session_start();

// As declarações 'use' devem vir aqui, após o session_start
use Src\Controller\PageController;
use Src\Controller\UsuariosController;
use Src\Controller\DashboardController;
use Src\Controller\PlanilhaController;
use Src\Model\PlanilhaDAO;

$page = $_GET['page'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'];

switch ($page) {
    case 'home':
        (new PageController())->home();
        break;

    case 'login':
        if ($method === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $user = UsuariosController::verPorEmail($email);
            if ($user && password_verify($senha, $user->getSenha())) {
                $_SESSION['usuario_id'] = $user->getId();
                $_SESSION['usuario_nome'] = $user->getNome();
                header('Location: index.php?page=planilhas');
                exit;
            } else {
                $erro = "E-mail ou senha incorretos.";
                require __DIR__ . '/../src/View/login.phtml';
            }
        } else {
            require __DIR__ . '/../src/View/login.phtml';
        }
        break;

    case 'cadastro':
        if ($method === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $confirmar_senha = $_POST['confirmar_senha'] ?? '';
            if ($senha !== $confirmar_senha) {
                $erro = "As senhas não coincidem.";
                require __DIR__ . '/../src/View/cadastro.phtml';
                exit;
            }
            try {
                $dados = ['nome' => $nome, 'email' => $email, 'senha' => $senha];
                UsuariosController::criar($dados);
                header('Location: index.php?page=login');
                exit;
            } catch (\Exception $e) {
                $erro = "Erro ao cadastrar: " . $e->getMessage();
                require __DIR__ . '/../src/View/cadastro.phtml';
                exit;
            }
        } else {
            require __DIR__ . '/../src/View/cadastro.phtml';
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?page=login');
        exit;

    case 'planilhas':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new DashboardController();
        $usuarioId = $_SESSION['usuario_id'];
        $controller->index($usuarioId);
        break;
        
    case 'usarPlanilha':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $id_planilha_pronta = $_GET['id'] ?? null;
        $usuarioId = $_SESSION['usuario_id'];
        if ($id_planilha_pronta) {
            PlanilhaController::copiar($id_planilha_pronta, $usuarioId);
        } else {
            header('Location: index.php?page=planilhas');
            exit;
        }
        break;
        
    case 'criarPlanilha':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new PlanilhaController();
        $controller->criar();
        break;
        
    case 'salvarPlanilha':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $controller = new PlanilhaController();
        $controller->salvar($_POST);
        break;
    
    case 'editarPlanilha':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $id_planilha = $_GET['id'] ?? null;
        $controller = new PlanilhaController();
        $controller->editar($id_planilha);
        break;

    default:
        (new PageController())->erro();
        break;
}