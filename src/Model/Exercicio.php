<?php
namespace Src\Model;

class Exercicio {
    private ?int $id;
    private ?string $nm_exercicio;
    private ?string $gp_muscular;
    private ?string $descricao; // Nome da coluna corrigido

    public function __construct(?int $id, ?string $nm_exercicio = null, ?string $gp_muscular = null, ?string $descricao = null) {
        $this->id = $id;
        $this->nm_exercicio = $nm_exercicio;
        $this->gp_muscular = $gp_muscular;
        $this->descricao = $descricao;
    }

    // Getters e Setters
    public function getId(): ?int { return $this->id; }
    public function getNmExercicio(): ?string { return $this->nm_exercicio; }
    public function getGpMuscular(): ?string { return $this->gp_muscular; }
    public function getDescricao(): ?string { return $this->descricao; } // Nome do getter corrigido

    public function setNmExercicio(string $nm_exercicio): void { $this->nm_exercicio = $nm_exercicio; }
    public function setGpMuscular(string $gp_muscular): void { $this->gp_muscular = $gp_muscular; }
    public function setDescricao(string $descricao): void { $this->descricao = $descricao; } // Nome do setter corrigido
}