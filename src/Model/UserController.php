<?php
namespace Src\Controller;

use Src\Model\UserModel;

require_once __DIR__ . "/../Model/UserModel.php";

class UserController {
    public function index() {
        $usuarios = UserModel::getAllUsers();
        include __DIR__ . "/../View/usuarios.phtml";
    }

    public function salvar($nome, $email) {
        UserModel::addUser($nome, $email);
        header("Location: /usuarios"); // redireciona
    }
}
