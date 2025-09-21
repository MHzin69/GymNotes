<?php
namespace Src\Controller;

use Src\Model\TreinoExercicios;
use Src\Model\TreinoExerciciosDAO;

class TreinoExerciciosController {
    public static function listar() { return TreinoExerciciosDAO::getAll(); }
    public static function ver(int $id) { return TreinoExerciciosDAO::getById($id); }
    public static function criar(array $dados) { 
        return TreinoExerciciosDAO::create(new TreinoExercicios(null, $dados['plano_id'], $dados['exercicio_id'], $dados['series'], $dados['repeticoes'])); 
    }
    public static function atualizar(int $id, array $dados) { 
        return TreinoExerciciosDAO::update(new TreinoExercicios($id, $dados['plano_id'], $dados['exercicio_id'], $dados['series'], $dados['repeticoes'])); 
    }
    public static function deletar(int $id) { return TreinoExerciciosDAO::delete($id); }
}
