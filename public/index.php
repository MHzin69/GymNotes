<?php
// Carrega os controllers e classes necessários
require_once __DIR__ . '/../src/Controller/PageController.php';
require_once __DIR__ . '/../src/Controller/UsuariosController.php'; 
require_once __DIR__ . '/../src/Controller/PlanilhaController.php';
require_once __DIR__ . '/../src/Model/Database.php'; 
require_once __DIR__ . '/../src/Model/UserDAO.php';
require_once __DIR__ . '/../src/Model/User.php';

session_start();

use Src\Controller\UsuariosController;
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
    case 'criarPlanilha':
    case 'salvarPlanilha':
        // Rotas protegidas (só acessíveis com login)
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $controller = new PlanilhaController();
        $usuarioId = $_SESSION['usuario_id'];

        switch ($page) {
            case 'planilhas':
                $controller->listar($usuarioId);
                break;
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
}
