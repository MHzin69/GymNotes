<?php
namespace Src\Model;

class ItemPlanilha {
    private ?int $id;
    private int $id_planilha;
    private int $id_exercicio;
    private ?int $series;
    private ?string $repeticoes;
    private ?string $carga;
    private ?string $observacoes;

    public function __construct(?int $id, int $id_planilha, int $id_exercicio, ?int $series = null, ?string $repeticoes = null, ?string $carga = null, ?string $observacoes = null) {
        $this->id = $id;
        $this->id_planilha = $id_planilha;
        $this->id_exercicio = $id_exercicio;
        $this->series = $series;
        $this->repeticoes = $repeticoes;
        $this->carga = $carga;
        $this->observacoes = $observacoes;
    }

    public function getId(): ?int { return $this->id; }
    public function getIdPlanilha(): int { return $this->id_planilha; }
    public function getIdExercicio(): int { return $this->id_exercicio; }
    public function getSeries(): ?int { return $this->series; }
    public function getRepeticoes(): ?string { return $this->repeticoes; }
    public function getCarga(): ?string { return $this->carga; }
    public function getObservacoes(): ?string { return $this->observacoes; }

    public function setIdPlanilha(int $id_planilha): void { $this->id_planilha = $id_planilha; }
    public function setIdExercicio(int $id_exercicio): void { $this->id_exercicio = $id_exercicio; }
    public function setSeries(int $series): void { $this->series = $series; }
    public function setRepeticoes(string $repeticoes): void { $this->repeticoes = $repeticoes; }
    public function setCarga(string $carga): void { $this->carga = $carga; }
    public function setObservacoes(string $observacoes): void { $this->observacoes = $observacoes; }
}