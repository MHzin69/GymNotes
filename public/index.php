<?php

require_once __DIR__ . '/../src/Controller/UsuariosController.php';

use Src\Controller\UsuariosController;

$usuarios = UsuariosController::listar();
foreach ($usuarios as $u) {
    echo $u->getNome() . " - " . $u->getEmail() . "<br>";
}
