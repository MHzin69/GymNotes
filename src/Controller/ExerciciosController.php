<?php
namespace Src\Controller;

use Src\Model\Exercicio;
use Src\Model\ExercicioDAO;

class ExerciciosController {
    public static function listar() { return ExercicioDAO::getAll(); }
    public static function ver(int $id) { return ExercicioDAO::getById($id); }
    public static function criar(array $dados) { return ExercicioDAO::create(new Exercicio(null, $dados['nome'], $dados['descricao'])); }
    public static function atualizar(int $id, array $dados) { return ExercicioDAO::update(new Exercicio($id, $dados['nome'], $dados['descricao'])); }
    public static function deletar(int $id) { return ExercicioDAO::delete($id); }
}
