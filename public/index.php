<?php
// Carrega todas as classes necessárias de forma organizada
require_once __DIR__ . '/../src/Controller/PageController.php';
require_once __DIR__ . '/../src/Controller/UsuariosController.php';
require_once __DIR__ . '/../src/Controller/PlanilhaController.php';
require_once __DIR__ . '/../src/Controller/DashboardController.php';
require_once __DIR__ . '/../src/Controller/ItemPlanilhaController.php';
require_once __DIR__ . '/../src/Controller/ExerciciosController.php';
require_once __DIR__ . '/../src/Model/Database.php';
require_once __DIR__ . '/../src/Model/UserDAO.php';
require_once __DIR__ . '/../src/Model/User.php';
require_once __DIR__ . '/../src/Model/PlanilhaDAO.php';
require_once __DIR__ . '/../src/Model/Planilha.php';
require_once __DIR__ . '/../src/Model/ItemPlanilhaDAO.php';
require_once __DIR__ . '/../src/Model/ItemPlanilha.php';
require_once __DIR__ . '/../src/Model/ExercicioDAO.php';
require_once __DIR__ . '/../src/Model/Exercicio.php';

session_start();

use Src\Controller\PageController;
use Src\Controller\UsuariosController;
use Src\Controller\DashboardController;
use Src\Controller\PlanilhaController;
use Src\Controller\ItemPlanilhaController;
use Src\Controller\ExerciciosController;
use Src\Model\PlanilhaDAO;
use Src\Model\ItemPlanilhaDAO;

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
        PlanilhaController::criar();
        break;

    case 'salvarPlanilha':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        PlanilhaController::salvar($_POST);
        break;

    case 'editarPlanilha':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $id_planilha = $_GET['id'] ?? null;
        PlanilhaController::editar($id_planilha);
        break;

    case 'salvarEdicao':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $id_planilha = $_POST['id'] ?? null;
        if ($id_planilha) {
            PlanilhaController::atualizar($id_planilha, $_POST);
            header('Location: index.php?page=planilhas');
            exit;
        } else {
            header('Location: index.php?page=erro');
            exit;
        }
        break;

    case 'deletarItem':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $id_item = $_GET['id'] ?? null;
        $id_planilha = $_GET['planilha_id'] ?? null;
        if ($id_item && $id_planilha) {
            ItemPlanilhaController::deletar($id_item);
            header("Location: index.php?page=editarPlanilha&id={$id_planilha}");
            exit;
        } else {
            header('Location: index.php?page=erro');
            exit;
        }
        break;

    case 'adicionarItem':
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php?page=login');
        exit;
    }
   
    $planilha_id = $_GET['planilha_id'] ?? null;
    $exercicio_id = $_GET['exercicio_id'] ?? null;
    ItemPlanilhaController::adicionar($planilha_id, $exercicio_id);
    break;

    case 'salvarItemPlanilha':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $planilha_id = $_POST['planilha_id'] ?? null;
        ItemPlanilhaController::salvar($_POST);
        header("Location: index.php?page=editarPlanilha&id={$planilha_id}");
        exit;
        
    case 'listaExercicios':
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $id_planilha = $_GET['id'] ?? null;
        $controller = new ExerciciosController();
        $controller->listarPorGrupoMuscular($id_planilha);
        break;

    default:
        (new PageController())->erro();
        break;
        case 'verPlanilha':
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php?page=login');
        exit;
    }
    $id_planilha = $_GET['id'] ?? null;
    

    $controller = new PlanilhaController();
    $controller->ver($id_planilha);
    break;
    
    case 'adicionarItem':
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: index.php?page=login');
        exit;
    }
    $planilha_id = $_GET['planilha_id'] ?? null;
    $exercicio_id = $_GET['exercicio_id'] ?? null;
    if ($planilha_id && $exercicio_id) {
        ItemPlanilhaController::adicionar($planilha_id, $exercicio_id);
    } else {
        header('Location: index.php?page=erro');
        exit;
    }
    break;
    }