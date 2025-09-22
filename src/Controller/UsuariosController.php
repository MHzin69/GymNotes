<?php
namespace Src\Controller;

use Src\Model\User;
use Src\Model\UserDAO;

class UsuariosController { 
    public static function listar() {
        return UserDAO::getAll();
    }

    public static function ver(int $id) {
        return UserDAO::getById($id);
    }

    public static function criar(array $dados) {
        if (!isset($dados['nome'], $dados['email'], $dados['senha'])) {
            throw new \InvalidArgumentException("Dados incompletos para criar usuário.");
        }
        $user = new User(null, $dados['nome'], $dados['email'], $dados['senha']);
        return UserDAO::create($user);
    }

    public static function atualizar(int $id, array $dados) {
        if (!isset($dados['nome'], $dados['email'], $dados['senha'])) {
            throw new \InvalidArgumentException("Dados incompletos para atualizar usuário.");
        }
        $user = new User($id, $dados['nome'], $dados['email'], $dados['senha']);
        return UserDAO::update($user);
    }

    public static function deletar(int $id) {
        return UserDAO::delete($id);
    }

    public static function verPorEmail(string $email): ?User {
    return UserDAO::getByEmail($email);
}
}
 