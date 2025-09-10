<?php

class LoginController {
    private function render($view, $data = []) {
        extract($data);
        include __DIR__ . '/../View/partials/header.phtml';
        include __DIR__ . '/../View/' . $view . '.phtml';
        include __DIR__ . '/../View/partials/footer.phtml';
    }

    // Exibe o formulário de login
    public function index() {
        $this->render('login', ['titulo' => 'Login']);
    }

    // Processa o formulário de login
    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            // Aqui depois você vai chamar o Model (ex: UsuarioModel) para verificar no banco
            if ($email === 'teste@email.com' && $senha === '123') {
                session_start();
                $_SESSION['usuario'] = $email;

                header("Location: /home");
                exit;
            } else {
                $this->render('login', [
                    'titulo' => 'Login',
                    'erro' => 'E-mail ou senha incorretos!'
                ]);
            }
        } else {
            header("Location: /login");
            exit;
        }
    }

    // Logout
    public function logout() {
        session_start();
        session_destroy();
        header("Location: /login");
        exit;
    }
}
