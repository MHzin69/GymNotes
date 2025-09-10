<?php
namespace Src\Controller;

use Src\Model\User;
use Src\Model\UserModel;

require_once __DIR__ . "/../Model/User.php";
require_once __DIR__ . "/../Model/UserModel.php";

class UserController {
    public function index() {
        $usuarios = UserModel::getAll();
        include __DIR__ . "/../View/usuarios.phtml";
    }

    public function salvar($nome, $email) {
        $usuario = new User($nome, $email);
        UserModel::add($usuario);
        header("Location: /usuarios");
    }
}
