<?php
namespace Src\Model;

class HistoricoCargas {
    private ?int $id;
    private int $exercicio_id;
    private float $carga;
    private string $data;

    public function __construct(?int $id, int $exercicio_id, float $carga, string $data) {
        $this->id = $id;
        $this->exercicio_id = $exercicio_id;
        $this->carga = $carga;
        $this->data = $data;
    }

    public function getId(): ?int { return $this->id; }
    public function getExercicioId(): int { return $this->exercicio_id; }
    public function getCarga(): float { return $this->carga; }
    public function getData(): string { return $this->data; }

    public function setExercicioId(int $id): void { $this->exercicio_id = $id; }
    public function setCarga(float $carga): void { $this->carga = $carga; }
    public function setData(string $data): void { $this->data = $data; }
}
