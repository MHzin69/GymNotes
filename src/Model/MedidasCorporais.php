<?php
namespace Src\Model;

class MedidasCorporais {
    private ?int $id;
    private int $usuario_id;
    private float $peso;
    private float $altura;
    private string $data;

    public function __construct(?int $id, int $usuario_id, float $peso, float $altura, string $data) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->peso = $peso;
        $this->altura = $altura;
        $this->data = $data;
    }

    public function getId(): ?int { return $this->id; }
    public function getUsuarioId(): int { return $this->usuario_id; }
    public function getPeso(): float { return $this->peso; }
    public function getAltura(): float { return $this->altura; }
    public function getData(): string { return $this->data; }

    public function setUsuarioId(int $id): void { $this->usuario_id = $id; }
    public function setPeso(float $peso): void { $this->peso = $peso; }
    public function setAltura(float $altura): void { $this->altura = $altura; }
    public function setData(string $data): void { $this->data = $data; }
}
