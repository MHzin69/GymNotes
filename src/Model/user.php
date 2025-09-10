<?php
namespace Src\Model;

class User {
    private $nome;
    private $email;

    public function __construct(string $nome, string $email) {
        $this->nome = $nome;
        $this->email = $email;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function toArray(): array {
        return [
            "nome" => $this->nome,
            "email" => $this->email
        ];
    }

    public static function fromArray(array $data): User {
        return new User($data['nome'], $data['email']);
    }
}
