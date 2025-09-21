<?php
namespace Src\Controller;

use Src\Model\MedidasCorporais;
use Src\Model\MedidasCorporaisDAO;

class MedidasCorporaisController {
    public static function listar() { return MedidasCorporaisDAO::getAll(); }
    public static function ver(int $id) { return MedidasCorporaisDAO::getById($id); }
    public static function criar(array $dados) { 
        return MedidasCorporaisDAO::create(new MedidasCorporais(null, $dados['usuario_id'], $dados['peso'], $dados['altura'], $dados['data'])); 
    }
    public static function atualizar(int $id, array $dados) { 
        return MedidasCorporaisDAO::update(new MedidasCorporais($id, $dados['usuario_id'], $dados['peso'], $dados['altura'], $dados['data'])); 
    }
    public static function deletar(int $id) { return MedidasCorporaisDAO::delete($id); }
}
