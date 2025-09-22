<?php
namespace Src\Controller;

require_once __DIR__ . '/../Model/Conexao.php'; // PDO

class ExercicioController
{
    public function listar()
    {
        $pdo = \Conexao::getInstance();

        // Busca exercícios com o grupo muscular
        $sql = "SELECT e.id, e.nome, e.descricao, e.imagem, g.nome AS grupo
                FROM exercicios e
                JOIN grupos_musculares g ON e.grupo_id = g.id
                ORDER BY g.nome, e.nome";
        $stmt = $pdo->query($sql);
        $dados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Organiza por grupo
        $grupos = [];
        foreach ($dados as $ex) {
            $grupos[$ex['grupo']][] = $ex;
        }

        require __DIR__ . '/../../views/exercicios/listar.php';
    }
}
