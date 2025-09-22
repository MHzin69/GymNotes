<?php
namespace Src\Controller;

use Src\Model\PlanoTreino;
use Src\Model\PlanoTreinoDAO;

class PlanosTreinoController {
    public static function listar() { return PlanoTreinoDAO::getAll(); }
    public static function ver(int $id) { return PlanoTreinoDAO::getById($id); }
    public static function criar(array $dados) { return PlanoTreinoDAO::create(new PlanoTreino(null, $dados['nome'], $dados['descricao'])); }
    public static function atualizar(int $id, array $dados) { return PlanoTreinoDAO::update(new PlanoTreino($id, $dados['nome'], $dados['descricao'])); }
    public static function deletar(int $id) { return PlanoTreinoDAO::delete($id); 
    }
}
