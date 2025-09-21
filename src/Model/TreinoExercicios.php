<?php
namespace Src\Model;

class TreinoExercicios {
    private ?int $id;
    private int $plano_id;
    private int $exercicio_id;
    private int $series;
    private int $repeticoes;

    public function __construct(?int $id, int $plano_id, int $exercicio_id, int $series, int $repeticoes) {
        $this->id = $id;
        $this->plano_id = $plano_id;
        $this->exercicio_id = $exercicio_id;
        $this->series = $series;
        $this->repeticoes = $repeticoes;
    }

    public function getId(): ?int { return $this->id; }
    public function getPlanoId(): int { return $this->plano_id; }
    public function getExercicioId(): int { return $this->exercicio_id; }
    public function getSeries(): int { return $this->series; }
    public function getRepeticoes(): int { return $this->repeticoes; }

    public function setPlanoId(int $plano_id): void { $this->plano_id = $plano_id; }
    public function setExercicioId(int $exercicio_id): void { $this->exercicio_id = $exercicio_id; }
    public function setSeries(int $series): void { $this->series = $series; }
    public function setRepeticoes(int $repeticoes): void { $this->repeticoes = $repeticoes; }
}
