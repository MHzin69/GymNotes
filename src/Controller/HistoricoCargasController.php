<?php
namespace Src\Controller;

use Src\Model\HistoricoCargas;
use Src\Model\HistoricoCargasDAO;

class HistoricoCargasController {
    public static function listar() { return HistoricoCargasDAO::getAll(); }
    public static function ver(int $id) { return HistoricoCargasDAO::getById($id); }
    public static function criar(array $dados) { 
        return HistoricoCargasDAO::create(new HistoricoCargas(null, $dados['exercicio_id'], $dados['carga'], $dados['data'])); 
    }
    public static function atualizar(int $id, array $dados) { 
        return HistoricoCargasDAO::update(new HistoricoCargas($id, $dados['exercicio_id'], $dados['carga'], $dados['data'])); 
    }
    public static function deletar(int $id) { return HistoricoCargasDAO::delete($id); }
}
