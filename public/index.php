<?php
// Carrega os controllers e classes necessários
require_once __DIR__ . '/../src/Controller/PageController.php';
require_once __DIR__ . '/../src/Controller/UsuariosController.php';
require_once __DIR__ . '/../src/Controller/PlanilhaController.php';
require_once __DIR__ . '/../src/Model/Database.php';
require_once __DIR__ . '/../src/Model/UserDAO.php';
require_once __DIR__ . '/../src/Model/User.php';
require_once __DIR__ . '/../src/Controller/DashboardController.php';
require_once __DIR__ . '/../src/Model/PlanilhaDAO.php';
require_once __DIR__ . '/../src/Model/Planilha.php';

session_start();

use Src\Controller\PageController;
use Src\Controller\UsuariosController;
use Src\Controller\DashboardController;
use Src\Model\PlanilhaDAO;
// Rota vinda pela URL
$page = $_GET['page'] ?? 'home';
$method = $_SERVER['REQUEST_METHOD'];

switch ($page) {
    case 'home':
        (new PageController())->home();
        break;

    case 'login':
        // Rota para exibir o formulário (GET) e processar o login (POST)
        if ($method === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            // Tenta buscar o usuário e verificar a senha
            $user = UsuariosController::verPorEmail($email);
            if ($user && password_verify($senha, $user->getSenha())) {
                $_SESSION['usuario_id'] = $user->getId();
                $_SESSION['usuario_nome'] = $user->getNome(); // Bom para exibir na tela
                header('Location: index.php?page=planilhas');
                exit;
            } else {
                // Login falhou, exibe a página de login com erro
                $erro = "E-mail ou senha incorretos.";
                require __DIR__ . '/../src/View/login.phtml'; // CORRIGIDO
            }
        } else {
            require __DIR__ . '/../src/View/login.phtml';
        }
        break;

    case 'cadastro':
        // Rota para exibir o formulário (GET) e processar o cadastro (POST)
        if ($method === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $confirmar_senha = $_POST['confirmar_senha'] ?? '';

            if ($senha !== $confirmar_senha) {
                $erro = "As senhas não coincidem.";
                require __DIR__ . '/../view/cadastro.phtml';
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

        // Usa o novo DashboardController para a página principal
        $controller = new DashboardController();
        $usuarioId = $_SESSION['usuario_id'];
        $controller->index($usuarioId);
        break;

    case 'criarPlanilha':
    case 'salvarPlanilha':
        // Mantenha essa parte do código, pois ela usa o PlanilhaController corretamente
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $controller = new PlanilhaController();
        $usuarioId = $_SESSION['usuario_id'];

        switch ($page) {
            case 'criarPlanilha':
                $controller->criar($usuarioId);
                break;
            case 'salvarPlanilha':
                $controller->salvar($usuarioId);
                break;
        }
        break;

    default:
        (new PageController())->erro();
        break;

    // No seu arquivo index.php, dentro do seu switch, adicione este novo caso
// ...
    case 'usarPlanilha':
        // Verifica se o usuário está logado
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id_planilha_pronta = $_GET['id'] ?? null;
        $usuarioId = $_SESSION['usuario_id'];

        if ($id_planilha_pronta) {
            // Chama o método para copiar a planilha
            PlanilhaController::copiar($id_planilha_pronta, $usuarioId);
        } else {
            header('Location: index.php?page=planilhas');
            exit;
        }
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

}
