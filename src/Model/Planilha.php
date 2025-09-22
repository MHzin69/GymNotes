<?php
namespace Src\Model;

class Planilha {
    private ?int $id_planilha;
    private int $id_usuario; 
    private string $nm_planilha; 
    private ?string $descricao;

    public function __construct(?int $id_planilha, int $id_usuario, string $nm_planilha, ?string $descricao = null) {
        $this->id_planilha = $id_planilha;
        $this->id_usuario = $id_usuario;
        $this->nm_planilha = $nm_planilha;
        $this->descricao = $descricao;
    }

    public function getId(): ?int { return $this->id_planilha; }
    public function getIdUsuario(): int { return $this->id_usuario; }
    public function getNmPlanilha(): string { return $this->nm_planilha; }
    public function getDescricao(): ?string { return $this->descricao; }

    public function setNmPlanilha(string $nm_planilha): void { $this->nm_planilha = $nm_planilha; }
    public function setDescricao(?string $descricao): void { $this->descricao = $descricao; }
}